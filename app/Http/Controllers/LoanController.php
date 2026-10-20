<?php

namespace App\Http\Controllers;

use App\Mail\LoanApprovedMail;
use App\Models\AuditLog;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Setting;
use App\Rules\UgandanNin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::whereHas('member', function ($q) {
            $q->where('user_id', auth()->user()->tenant_id);
        })->with('member')->orderBy('id', 'desc')->paginate(15);

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        // Only active members can be selected for loan applications
        $members = Member::where('user_id', auth()->user()->tenant_id)
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('loans.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'principal_amount' => 'required|numeric|min:1000',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration_months' => 'required|integer|min:1|max:120',
            'collateral_description' => 'required|string|max:500',
            'collateral_value' => 'required|numeric|min:0',
            'guarantor_name' => 'required|string|max:255',
            'guarantor_contact' => 'required|string|max:255',
            'guarantor_nin' => ['required', 'string', new UgandanNin],
        ]);

        $member = Member::where('id', $validated['member_id'])
            ->where('user_id', auth()->user()->tenant_id)
            ->firstOrFail();

        // Enforce: Suspended and inactive members cannot get loans
        if ($member->status !== 'Active') {
            return back()->withErrors([
                'member_id' => "Cannot issue a loan to a member with status: {$member->status}. Only Active members are eligible for loans.",
            ])->withInput();
        }

        $savingsBalance = $member->savingsAccounts()->where('status', 'Active')->sum('balance');
        $maxLoan = $savingsBalance * 3;

        if ($validated['principal_amount'] > $maxLoan) {
            return back()->withErrors([
                'principal_amount' => 'Requested amount exceeds 3x the member\'s active savings balance. Maximum eligible loan is UGX '.number_format($maxLoan, 2),
            ])->withInput();
        }

        $principal = $validated['principal_amount'];
        $rate = $validated['interest_rate'];
        $totalPayable = $principal + ($principal * ($rate / 100));

        $validated['total_payable'] = $totalPayable;
        $validated['balance'] = 0; // Balance is 0 until approved/disbursed
        $validated['penalty_amount'] = 0;
        $validated['status'] = 'Pending';
        $validated['guarantor_nin'] = strtoupper(preg_replace('/\s+/', '', $validated['guarantor_nin']));

        $loan = Loan::create($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Loan application submitted successfully and is pending approval.');
    }

    public function show(Loan $loan)
    {
        $loan->load('member', 'repayments');

        return view('loans.show', compact('loan'));
    }

    public function approve(Request $request, Loan $loan)
    {
        if ($loan->status !== 'Pending') {
            return back()->with('error', 'Only pending loans can be approved.');
        }

        if ($loan->member->status !== 'Active') {
            return back()->with('error', "Cannot disburse loan: member is currently {$loan->member->status}. Only active members can receive disbursements.");
        }

        $dueDate = Carbon::now()->addMonths($loan->duration_months)->toDateString();

        $loan->update([
            'status' => 'Active',
            'balance' => $loan->total_payable,
            'due_date' => $dueDate,
            'approved_at' => now(),
        ]);

        if (Setting::getValue('email_notifications', '1') === '1' && Setting::getValue('notify_loan_approval', '1') === '1') {
            if (filter_var($loan->member->contact, FILTER_VALIDATE_EMAIL)) {
                Mail::to($loan->member->contact)->send(new LoanApprovedMail($loan));
            }
        }

        return back()->with('success', 'Loan approved and activated successfully. Repayment tracking and maturity schedule started.');
    }

    public function applyPenalty(Request $request, Loan $loan)
    {
        if ($loan->status !== 'Active' || $loan->balance <= 0) {
            return back()->with('error', 'Late penalties can only be applied to active loans with an outstanding balance.');
        }

        $validated = $request->validate([
            'penalty_type' => 'required|in:fixed,percentage',
            'penalty_value' => 'required|numeric|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $penaltyCharge = 0;
        if ($validated['penalty_type'] === 'percentage') {
            $penaltyCharge = round(($loan->balance * ($validated['penalty_value'] / 100)), 2);
        } else {
            $penaltyCharge = round($validated['penalty_value'], 2);
        }

        $loan->increment('penalty_amount', $penaltyCharge);
        $loan->increment('balance', $penaltyCharge);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Apply Late Penalty',
            'details' => 'Applied penalty fee of UGX '.number_format($penaltyCharge, 2)." to Loan #{$loan->id}. Reason: ".($validated['notes'] ?? 'Overdue installment/default penalty.'),
        ]);

        return back()->with('success', 'Late penalty fee of UGX '.number_format($penaltyCharge, 2).' applied successfully.');
    }

    public function flagDefault(Request $request, Loan $loan)
    {
        if ($loan->status !== 'Active') {
            return back()->with('error', 'Only active loans can be flagged for default.');
        }

        $loan->update(['status' => 'Defaulted']);

        // Security measure: Suspend the member's account to prevent further withdrawals or loans
        $loan->member->update(['status' => 'Suspended']);
        $loan->member->savingsAccounts()->update(['status' => 'Inactive']);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Flag Loan Default & Suspend Member',
            'details' => "Loan #{$loan->id} flagged as Defaulted. Member #{$loan->member->member_number} ({$loan->member->name}) has been automatically Suspended as a recovery security measure.",
        ]);

        return back()->with('success', 'Loan marked as Defaulted. As a security measure, member privileges and savings have been restricted/suspended until the outstanding balance of UGX '.number_format($loan->balance, 2).' is resolved.');
    }
}
