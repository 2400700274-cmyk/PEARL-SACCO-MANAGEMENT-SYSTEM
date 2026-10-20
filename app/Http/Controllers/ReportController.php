<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Repayment;
use App\Models\SavingsAccount;

class ReportController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->tenant_id;
        $memberIds = Member::where('user_id', $userId)->pluck('id');

        $metrics = [
            'total_members' => Member::where('user_id', $userId)->count(),
            'active_members' => Member::where('user_id', $userId)->where('status', 'Active')->count(),

            'total_savings' => SavingsAccount::whereIn('member_id', $memberIds)->sum('balance'),

            'total_loans_disbursed' => Loan::whereIn('member_id', $memberIds)->whereIn('status', ['Active', 'Completed'])->sum('principal_amount'),
            'outstanding_loan_balance' => Loan::whereIn('member_id', $memberIds)->where('status', 'Active')->sum('balance'),

            'total_repayments' => Repayment::whereHas('loan', function ($q) use ($memberIds) {
                $q->whereIn('member_id', $memberIds);
            })->sum('amount'),
        ];

        $recentLoans = Loan::whereIn('member_id', $memberIds)->with('member')->orderBy('id', 'desc')->take(5)->get();

        // Chart Data: Savings vs Outstanding Loans
        $totalSavings = $metrics['total_savings'];
        $outstandingLoans = $metrics['outstanding_loan_balance'];

        $chartData = [
            'labels' => ['Total Savings (UGX)', 'Outstanding Loans (UGX)'],
            'data' => [$totalSavings, $outstandingLoans],
        ];

        return view('reports.index', compact('metrics', 'recentLoans', 'chartData'));
    }

    public function exportExcel()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=sacco_report_'.date('Y-m-d').'.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $metrics = [
            'Total Members' => Member::count(),
            'Active Members' => Member::where('status', 'Active')->count(),
            'Total Savings (UGX)' => SavingsAccount::sum('balance'),
            'Outstanding Loan Balance (UGX)' => Loan::where('status', 'Active')->sum('balance'),
            'Total Repayments (UGX)' => Repayment::sum('amount'),
        ];

        $callback = function () use ($metrics) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Metric', 'Value']);
            foreach ($metrics as $key => $value) {
                fputcsv($file, [$key, $value]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $metrics = [
            'total_members' => Member::count(),
            'active_members' => Member::where('status', 'Active')->count(),
            'total_savings' => SavingsAccount::sum('balance'),
            'outstanding_loan_balance' => Loan::where('status', 'Active')->sum('balance'),
            'total_repayments' => Repayment::sum('amount'),
        ];

        $recentLoans = Loan::with('member')->orderBy('id', 'desc')->take(10)->get();

        return view('reports.print', compact('metrics', 'recentLoans'));
    }
}
