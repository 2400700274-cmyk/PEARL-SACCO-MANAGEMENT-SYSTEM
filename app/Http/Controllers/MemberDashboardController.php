<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Loan;
use App\Models\Member;
use App\Models\SavingsTransaction;
use App\Models\Setting;
use App\Rules\UgandanNin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberDashboardController extends Controller
{
    /**
     * Resolve the active member for the authenticated user or preview request.
     */
    protected function resolveMember(?int $memberId = null): ?Member
    {
        $user = auth()->user();

        // 1. If user is explicitly a member with a linked Member model
        if ($user->isMember() && $user->member) {
            return $user->member;
        }

        // 2. Staff/Admin viewing a specific member's portal
        if ($memberId && $user->hasPermission('view-members')) {
            return Member::where('id', $memberId)
                ->where('user_id', $user->tenant_id)
                ->first();
        }

        // 3. Fallback: If user is admin/staff without member_id, pick the first active member of their SACCO for demo
        if ($user->hasPermission('view-members')) {
            return Member::where('user_id', $user->tenant_id)->orderBy('id')->first();
        }

        return null;
    }

    /**
     * Display the member self-service dashboard.
     */
    public function index(Request $request)
    {
        $memberId = $request->query('member_id');
        $member = $this->resolveMember($memberId ? (int) $memberId : null);

        if (! $member) {
            return redirect()->route('dashboard')->with('error', 'No member profile is linked to your user account.');
        }

        // Summary Cards
        $totalSavings = $member->total_savings_balance;
        $activeLoanBalance = $member->active_loan_balance;
        $availableLoanLimit = $member->available_loan_limit;

        // Savings transactions query with date range filter (Requirement MD-014)
        $accountIds = $member->savingsAccounts()->pluck('id');
        $transactionsQuery = SavingsTransaction::whereIn('savings_account_id', $accountIds);

        if ($request->filled('from_date')) {
            $transactionsQuery->whereDate('transaction_date', '>=', $request->query('from_date'));
        }

        if ($request->filled('to_date')) {
            $transactionsQuery->whereDate('transaction_date', '<=', $request->query('to_date'));
        }

        $transactions = $transactionsQuery->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'transactions_page')
            ->withQueryString();

        // Loans (Requirement MD-021, MD-024)
        $loans = $member->loans()
            ->with('repayments')
            ->orderBy('id', 'desc')
            ->get();

        $activeLoans = $loans->whereIn('status', ['Active', 'Pending']);
        $completedLoans = $loans->where('status', 'Completed');

        // Repayment Schedules for active loans (Requirement MD-026, MD-027)
        $selectedLoanId = $request->query('loan_id');
        $activeLoanForSchedule = $activeLoans->where('status', 'Active')->first();

        if ($selectedLoanId) {
            $matched = $loans->where('id', $selectedLoanId)->first();
            if ($matched) {
                $activeLoanForSchedule = $matched;
            }
        }

        return view('member.dashboard', compact(
            'member',
            'totalSavings',
            'activeLoanBalance',
            'availableLoanLimit',
            'transactions',
            'loans',
            'activeLoans',
            'completedLoans',
            'activeLoanForSchedule'
        ));
    }

    /**
     * Apply for a new loan online (Requirement MD-020).
     */
    public function applyLoan(Request $request)
    {
        $member = $this->resolveMember($request->input('member_id') ? (int) $request->input('member_id') : null);

        if (! $member) {
            return back()->with('error', 'Unable to resolve eligible member profile.');
        }

        if ($member->status !== 'Active') {
            return back()->with('error', "Your membership account is currently {$member->status}. Only Active members can apply for loans.");
        }

        $validated = $request->validate([
            'loan_type' => ['required', 'string', 'max:255'],
            'requested_amount' => ['required', 'numeric', 'min:1000'],
            'duration_months' => ['required', 'integer', 'min:1', 'max:36'],
            'loan_purpose' => ['required', 'string', 'max:1000'],
            'collateral_description' => ['nullable', 'string', 'max:500'],
            'collateral_value' => ['nullable', 'numeric', 'min:0'],
            'guarantor_name' => ['nullable', 'string', 'max:255'],
            'guarantor_contact' => ['nullable', 'string', 'max:255'],
            'guarantor_nin' => ['nullable', 'string', new UgandanNin],
        ]);

        $savingsBalance = $member->total_savings_balance;
        $maxEligible = $savingsBalance * 3;

        if ($validated['requested_amount'] > $maxEligible) {
            return back()->withErrors([
                'requested_amount' => 'Requested amount exceeds 3x your active savings balance. Your maximum eligible loan limit is UGX '.number_format($maxEligible, 2),
            ])->withInput();
        }

        // Standard interest rate (default 10% or SACCO setting)
        $interestRate = (float) Setting::getValue('loan_interest_rate', '10.0');
        $principal = $validated['requested_amount'];
        $totalPayable = $principal + ($principal * ($interestRate / 100));

        $loan = $member->loans()->create([
            'loan_type' => $validated['loan_type'],
            'principal_amount' => $principal,
            'interest_rate' => $interestRate,
            'duration_months' => $validated['duration_months'],
            'loan_purpose' => $validated['loan_purpose'],
            'total_payable' => $totalPayable,
            'balance' => 0, // Balance activates upon disbursement
            'penalty_amount' => 0,
            'collateral_description' => $validated['collateral_description'] ?? 'Member Savings Collateral',
            'collateral_value' => $validated['collateral_value'] ?? $savingsBalance,
            'guarantor_name' => $validated['guarantor_name'] ?? null,
            'guarantor_contact' => $validated['guarantor_contact'] ?? null,
            'guarantor_nin' => isset($validated['guarantor_nin']) ? strtoupper(preg_replace('/\s+/', '', $validated['guarantor_nin'])) : null,
            'status' => 'Pending',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Apply Loan Online',
            'description' => "Member {$member->name} submitted online application for LN-".str_pad($loan->id, 5, '0', STR_PAD_LEFT)." ({$validated['loan_type']}) of UGX ".number_format($principal, 2),
            'record_type' => 'Loan',
            'record_id' => $loan->id,
        ]);

        return redirect()->route('member.dashboard', ['member_id' => $member->id])
            ->with('success', 'Your online loan application for UGX '.number_format($principal, 2).' has been submitted successfully and is pending review.');
    }

    /**
     * Download or print savings statement (Requirement MD-014).
     */
    public function downloadSavingsStatement(Request $request)
    {
        $member = $this->resolveMember($request->input('member_id') ? (int) $request->input('member_id') : null);

        if (! $member) {
            return redirect()->route('member.dashboard')->with('error', 'Member record not found.');
        }

        $accountIds = $member->savingsAccounts()->pluck('id');
        $query = SavingsTransaction::whereIn('savings_account_id', $accountIds);

        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        if ($fromDate) {
            $query->whereDate('transaction_date', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('transaction_date', '<=', $toDate);
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->orderBy('id', 'asc')->get();
        $format = $request->query('format', 'print');

        // CSV Export
        if ($format === 'csv') {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=savings_statement_'.$member->member_number.'_'.date('Y-m-d').'.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $callback = function () use ($member, $transactions) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['SAVINGS ACCOUNT STATEMENT - '.Setting::getValue('sacco_name', 'Pearl SACCO')]);
                fputcsv($file, ['Member Name', $member->name]);
                fputcsv($file, ['Member Number', $member->member_number]);
                fputcsv($file, ['Statement Date', date('Y-m-d H:i')]);
                fputcsv($file, ['Current Balance (UGX)', number_format($member->total_savings_balance, 2)]);
                fputcsv($file, []);
                fputcsv($file, ['Transaction Date', 'Type', 'Amount (UGX)', 'Description']);

                foreach ($transactions as $tx) {
                    fputcsv($file, [
                        $tx->transaction_date ? $tx->transaction_date->format('Y-m-d') : 'N/A',
                        $tx->type,
                        number_format($tx->amount, 2),
                        $tx->description,
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Print/PDF View
        return view('member.savings-statement', compact('member', 'transactions', 'fromDate', 'toDate'));
    }

    /**
     * Download or print loan repayment statement (Requirement MD-028).
     */
    public function downloadLoanStatement(Request $request, Loan $loan)
    {
        $member = $this->resolveMember($request->input('member_id') ? (int) $request->input('member_id') : null);

        // Verify loan belongs to this member
        if (! $member || $loan->member_id !== $member->id) {
            abort(404);
        }

        $loan->load('member', 'repayments');
        $format = $request->query('format', 'print');

        if ($format === 'csv') {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=loan_statement_LN_'.str_pad($loan->id, 5, '0', STR_PAD_LEFT).'_'.date('Y-m-d').'.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $callback = function () use ($loan) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['LOAN REPAYMENT STATEMENT - '.Setting::getValue('sacco_name', 'Pearl SACCO')]);
                fputcsv($file, ['Loan ID', 'LN-'.str_pad($loan->id, 5, '0', STR_PAD_LEFT)]);
                fputcsv($file, ['Member Name', $loan->member->name]);
                fputcsv($file, ['Member Number', $loan->member->member_number]);
                fputcsv($file, ['Loan Type', $loan->loan_type ?? 'Agricultural Loan']);
                fputcsv($file, ['Principal Amount (UGX)', number_format($loan->principal_amount, 2)]);
                fputcsv($file, ['Interest Rate (%)', $loan->interest_rate]);
                fputcsv($file, ['Total Payable (UGX)', number_format($loan->effective_total, 2)]);
                fputcsv($file, ['Total Paid (UGX)', number_format($loan->amount_paid, 2)]);
                fputcsv($file, ['Remaining Balance (UGX)', number_format($loan->balance, 2)]);
                fputcsv($file, ['Overdue Penalties (UGX)', number_format($loan->penalty_amount, 2)]);
                fputcsv($file, ['Status', $loan->status]);
                fputcsv($file, []);
                fputcsv($file, ['REPAYMENT HISTORY']);
                fputcsv($file, ['Payment ID', 'Payment Date', 'Amount (UGX)', 'Status']);

                foreach ($loan->repayments as $rep) {
                    fputcsv($file, [
                        'RP-'.str_pad($rep->id, 5, '0', STR_PAD_LEFT),
                        $rep->paid_at ? $rep->paid_at->format('Y-m-d H:i') : 'N/A',
                        number_format($rep->amount, 2),
                        $rep->status,
                    ]);
                }

                fputcsv($file, []);
                fputcsv($file, ['SCHEDULED INSTALLMENTS']);
                fputcsv($file, ['Installment #', 'Due Date', 'Installment Amount (UGX)', 'Amount Paid (UGX)', 'Remaining Balance (UGX)', 'Status']);

                foreach ($loan->repayment_schedule as $sch) {
                    fputcsv($file, [
                        $sch['installment_number'],
                        $sch['due_date']->format('Y-m-d'),
                        number_format($sch['installment_amount'], 2),
                        number_format($sch['amount_paid'], 2),
                        number_format($sch['remaining_balance'], 2),
                        $sch['status'],
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return view('member.loan-statement', compact('loan'));
    }

    /**
     * Change member password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Your password has been changed successfully.');
    }
}
