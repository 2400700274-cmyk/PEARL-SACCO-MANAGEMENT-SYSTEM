<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepaymentController extends Controller
{
    public function index()
    {
        $repayments = Repayment::whereHas('loan.member', function ($q) {
            $q->where('user_id', auth()->user()->tenant_id);
        })->with('loan.member')->orderBy('id', 'desc')->paginate(15);

        return view('repayments.index', compact('repayments'));
    }

    public function create(Loan $loan)
    {
        if ($loan->status !== 'Active') {
            return redirect()->route('loans.show', $loan)->with('error', 'You can only record repayments for active loans.');
        }

        return view('repayments.create', compact('loan'));
    }

    public function store(Request $request, Loan $loan)
    {
        if ($loan->status !== 'Active') {
            return redirect()->route('loans.show', $loan)->with('error', 'You can only record repayments for active loans.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:'.$loan->balance],
            'paid_at' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($validated, $loan) {
            $loan->repayments()->create([
                'amount' => $validated['amount'],
                'paid_at' => $validated['paid_at'],
                'status' => 'Completed',
            ]);

            $loan->decrement('balance', $validated['amount']);

            if ($loan->balance <= 0) {
                $loan->update(['status' => 'Completed']);
            }
        });

        return redirect()->route('loans.show', $loan)->with('success', 'Repayment recorded successfully.');
    }
}
