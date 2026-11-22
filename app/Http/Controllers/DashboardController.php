<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\SavingsAccount;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isMember()) {
            return redirect()->route('member.dashboard');
        }

        $userId = auth()->user()->tenant_id;

        // Base query for user's members
        $memberQuery = clone Member::where('user_id', $userId);
        $memberIds = $memberQuery->pluck('id');

        $metrics = [
            'total_members' => $memberQuery->count(),
            'active_loans' => Loan::whereIn('member_id', $memberIds)->where('status', 'Active')->count(),
            'outstanding_balance' => Loan::whereIn('member_id', $memberIds)->where('status', 'Active')->sum('balance'),
            'savings_balance' => SavingsAccount::whereIn('member_id', $memberIds)->sum('balance'),
        ];

        $recentLoans = Loan::whereIn('member_id', $memberIds)->with('member')->orderBy('id', 'desc')->take(3)->get();
        $recentMembers = Member::where('user_id', $userId)->orderBy('id', 'desc')->take(3)->get();

        return view('dashboard', compact('metrics', 'recentLoans', 'recentMembers'));
    }
}
