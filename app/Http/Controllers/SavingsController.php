<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\SavingsAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavingsController extends Controller
{
    public function index()
    {
        $accounts = SavingsAccount::whereHas('member', function ($q) {
            $q->where('user_id', auth()->user()->tenant_id);
        })->with('member')->orderBy('id', 'desc')->paginate(15);

        return view('savings.index', compact('accounts'));
    }

    public function show(SavingsAccount $saving)
    {
        $saving->load(['member', 'transactions' => function ($q) {
            $q->latest('transaction_date')->latest('id');
        }]);

        return view('savings.show', compact('saving'));
    }

    public function createTransaction(SavingsAccount $saving)
    {
        if ($saving->member->status !== 'Active') {
            return redirect()->route('savings.show', $saving)->with('error', "Transactions are prohibited because this member is currently {$saving->member->status}. Suspended and inactive members cannot make savings or withdrawals.");
        }

        return view('savings.transaction', compact('saving'));
    }

    public function storeTransaction(Request $request, SavingsAccount $saving)
    {
        // Enforce: Suspended and inactive members cannot make savings or withdraw
        if ($saving->member->status !== 'Active') {
            return back()->withErrors([
                'amount' => "Transactions prohibited: Member account status is {$saving->member->status}. Suspended and inactive members cannot make savings or withdraw funds.",
            ])->withInput();
        }

        $validated = $request->validate([
            'type' => 'required|string|in:Deposit,Withdrawal',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validated['type'] === 'Withdrawal') {
            if ($saving->balance < $validated['amount']) {
                return back()->withErrors(['amount' => 'Insufficient funds for this withdrawal.'])->withInput();
            }

            // Security measure: Check for active loans
            $activeLoanBalance = Loan::where('member_id', $saving->member_id)
                ->whereIn('status', ['Active', 'Defaulted'])
                ->sum('balance');

            if ($activeLoanBalance > 0) {
                // Minimum security reserve: Member must keep at least 20% of their savings or minimum UGX 50,000 as collateral hold while active loans exist
                $minReserve = max(50000, $saving->balance * 0.20);
                if (($saving->balance - $validated['amount']) < $minReserve) {
                    return back()->withErrors([
                        'amount' => 'Security Hold: Member has an active outstanding loan balance of UGX '.number_format($activeLoanBalance, 2).'. A mandatory loan security reserve of UGX '.number_format($minReserve, 2).' must remain in the savings account until the loan is settled.',
                    ])->withInput();
                }
            }
        }

        DB::transaction(function () use ($validated, $saving) {
            $saving->transactions()->create($validated);

            if ($validated['type'] === 'Deposit') {
                $saving->increment('balance', $validated['amount']);
            } else {
                $saving->decrement('balance', $validated['amount']);
            }
        });

        return redirect()->route('savings.show', $saving)->with('success', 'Transaction recorded successfully.');
    }
}
