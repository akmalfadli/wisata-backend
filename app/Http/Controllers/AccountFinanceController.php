<?php

namespace App\Http\Controllers;

use App\Models\AccountFinance;
use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\Debit;
use Illuminate\Support\Facades\DB;

class AccountFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $accounts = AccountFinance::select(
            'account_finances.id',
            'account_finances.name',
            'account_finances.account_number',
            'account_finances.account_type',
            DB::raw('COALESCE(credit_totals.total_credit, 0) as total_credit'),
            DB::raw('COALESCE(debit_totals.total_debit, 0) as total_debit')
        )
        ->leftJoinSub(
            Credit::select('account_finance_id', DB::raw('SUM(nominal) as total_credit'))
                ->groupBy('account_finance_id'),
            'credit_totals',
            'account_finances.id',
            '=',
            'credit_totals.account_finance_id'
        )
        ->leftJoinSub(
            Debit::select('account_finance_id', DB::raw('SUM(nominal) as total_debit'))
                ->groupBy('account_finance_id'),
            'debit_totals',
            'account_finances.id',
            '=',
            'debit_totals.account_finance_id'
        )
        ->get()
        ->map(function ($account) {
            return [
                'id' => $account->id,
                'name' => $account->name,
                'account_number' => $account->account_number,
                'account_type' => $account->account_type,
                'total_credit' => $account->total_credit,
                'total_debit' => $account->total_debit,
            ];
        });
        //dd($accounts);
        return view('pages.finance.account.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.finance.account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "description" => "required"
        ]);

        AccountFinance::create([
            "name" => $request->name,
            "account_number" => $request->account_number,
            "account_type" => $request->account_type,
            "description" => $request->description,

        ]);
        return redirect()->route('finance.account.index')->with('success', 'Account created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountFinance $accountFinance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountFinance $accountFinance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountFinance $accountFinance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountFinance $accountFinance)
    {
        //
    }
}
