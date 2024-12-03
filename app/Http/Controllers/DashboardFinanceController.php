<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\Debit;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardFinanceController extends Controller {
    public function index(Request $request){

        $thisMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $thisMonthEnd = Carbon::now()->endOfMonth()->toDateString();

        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $saldos = [
            'Semua Saldo' => DB::table('credits')
                                ->selectRaw('(COALESCE(SUM(credits.nominal), 0) - COALESCE((SELECT SUM(debits.nominal) FROM debits), 0)) AS balance')
                                ->value('balance'), // Sum of all nominal values
            'Saldo bulan ini' => DB::table('credits')
                                ->selectRaw(
                                    '(COALESCE(SUM(credits.nominal), 0) - COALESCE((SELECT SUM(debits.nominal) FROM debits WHERE debits.debit_date BETWEEN ? AND ?), 0)) AS balance',
                                    [$thisMonthStart, $thisMonthEnd]
                                )
                                ->whereBetween('credits.credit_date', [$thisMonthStart, $thisMonthEnd])
                                ->value('balance'),
            'Saldo bulan lalu' => DB::table('credits')
                                ->selectRaw('(COALESCE(SUM(credits.nominal), 0) - COALESCE((SELECT SUM(debits.nominal) FROM debits WHERE debits.debit_date BETWEEN ? AND ?), 0)) AS balance', [$lastMonthStart, $lastMonthEnd])
                                ->whereBetween('credits.credit_date', [$lastMonthStart, $lastMonthEnd])
                                ->value('balance')

        ];

        $credits = DB::table('credits')
            ->join('users', 'users.id', '=', 'credits.created_by')
            ->select('credits.id', 'credits.name', 'credits.nominal', 'credits.description', 'credits.credit_date', 'credits.account_finance_id', 'credits.category_id', 'credits.created_by', 'credits.updated_by', 'credits.created_at', 'credits.updated_at', 'users.name as user_name')
            ->orderBy('credits.created_at', 'desc')
            ->limit(5);

        $debits = DB::table('debits')
            ->join('users', 'users.id', '=', 'debits.created_by')
            ->select('debits.id', 'debits.name', 'debits.nominal', 'debits.description', 'debits.debit_date', 'debits.account_finance_id', 'debits.category_id', 'debits.created_by', 'debits.updated_by', 'debits.created_at', 'debits.updated_at', 'users.name as user_name')
            ->orderBy('debits.created_at', 'desc')
            ->limit(5);

        // Combine the queries using unionAll
        $transactions = $credits->unionAll($debits)
            ->orderBy('created_at', 'desc')  // Sort the combined results by created_at
            ->limit(5) // Limit the final result to 5 rows
            ->get();
        // Convert created_at to Carbon instances
        $transactions = $transactions->map(function ($transaction) {
            $transaction->created_at = Carbon::parse($transaction->created_at); // Convert to Carbon
            return $transaction;
        });

        if ($request->date == "this_month") {
            $thisMonth = Carbon::now()->month;
            $thisYear = Carbon::now()->year;
		} elseif ($request->date == "last_month") {
            $thisMonth = Carbon::now()->subMonth()->month;
            $thisYear = Carbon::now()->subMonth()->year;
		} else {
            $thisMonth = Carbon::now()->month;
            $thisYear = Carbon::now()->year;
		}

        $credits = DB::table('credits')
            ->selectRaw('DATE(credit_date) as credit_date, SUM(nominal) as total_nominal')
            ->whereMonth('credit_date', $thisMonth) // Filter by current month
            ->whereYear('credit_date', $thisYear)   // Filter by current year
            ->groupBy('credit_date') // Group by the date
            ->orderBy('credit_date', 'asc') // Order by date ascending
            ->get();

        if ($request->ajax()) {
        	return response()->json($credits);
    	}

        return view('pages.finance.dashboard', compact(['saldos', 'transactions', 'credits']));
    }
}
