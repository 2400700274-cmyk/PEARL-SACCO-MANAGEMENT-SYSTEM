<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Loan;
use App\Models\Setting;
use App\Mail\LoanApprovedMail;
use App\Models\Member;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::whereHas('member', function($q) {
            $q->where('user_id', auth()->user()->tenant_id);
        })->with('member')->orderBy('id', 'desc')->paginate(15);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $members = Member::where('user_id', auth()->user()->tenant_id)->orderBy('name')->get();
        return view('loans.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'principal_amount' => 'required|numeric|min:1000',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration_months' => 'required|integer|min:1|max:120',
        ]);

        $member = Member::find($validated['member_id']);
        $savingsBalance = $member->savingsAccounts()->sum('balance');
        $maxLoan = $savingsBalance * 3;

        if ($validated['principal_amount'] > $maxLoan) {
            return back()->withErrors([
                'principal_amount' => 'Requested amount exceeds 3x the member\'s savings balance. Maximum eligible loan is UGX ' . number_format($maxLoan, 2)
            ])->withInput();
        }

        $principal = $validated['principal_amount'];
        $rate = $validated['interest_rate'];
        $totalPayable = $principal + ($principal * ($rate / 100));

        $validated['total_payable'] = $totalPayable;
        $validated['balance'] = 0; // Balance is 0 until approved/disbursed
        $validated['status'] = 'Pending';

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

        $loan->update([
            'status' => 'Active',
            'balance' => $loan->total_payable,
            'approved_at' => now(),
        ]);

        if (Setting::getValue('email_notifications', '1') === '1' && Setting::getValue('notify_loan_approval', '1') === '1') {
            if (filter_var($loan->member->contact, FILTER_VALIDATE_EMAIL)) {
                Mail::to($loan->member->contact)->send(new LoanApprovedMail($loan));
            }
        }

        return back()->with('success', 'Loan approved and activated successfully.');
    }
}
