<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use Illuminate\Support\Facades\DB;

class SavingsController extends Controller
{
    public function index()
    {
        $accounts = SavingsAccount::whereHas('member', function($q) {
            $q->where('user_id', auth()->user()->tenant_id);
        })->with('member')->orderBy('id', 'desc')->paginate(15);
        return view('savings.index', compact('accounts'));
    }

    public function show(SavingsAccount $saving)
    {
        $saving->load(['member', 'transactions' => function($q) {
            $q->latest('transaction_date')->latest('id');
        }]);
        return view('savings.show', compact('saving'));
    }

    public function createTransaction(SavingsAccount $saving)
    {
        return view('savings.transaction', compact('saving'));
    }

    public function storeTransaction(Request $request, SavingsAccount $saving)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:Deposit,Withdrawal',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validated['type'] === 'Withdrawal' && $saving->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient funds for this withdrawal.'])->withInput();
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
