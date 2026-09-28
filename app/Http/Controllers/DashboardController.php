<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->tenant_id;

        // Base query for user's members
        $memberQuery = clone \App\Models\Member::where('user_id', $userId);
        $memberIds = $memberQuery->pluck('id');

        $metrics = [
            'total_members' => $memberQuery->count(),
            'active_loans' => \App\Models\Loan::whereIn('member_id', $memberIds)->where('status', 'Active')->count(),
            'outstanding_balance' => \App\Models\Loan::whereIn('member_id', $memberIds)->where('status', 'Active')->sum('balance'),
            'savings_balance' => \App\Models\SavingsAccount::whereIn('member_id', $memberIds)->sum('balance'),
        ];
        
        $recentLoans = \App\Models\Loan::whereIn('member_id', $memberIds)->with('member')->orderBy('id', 'desc')->take(3)->get();
        $recentMembers = \App\Models\Member::where('user_id', $userId)->orderBy('id', 'desc')->take(3)->get();

        return view('dashboard', compact('metrics', 'recentLoans', 'recentMembers'));
    }
}
