<?php

namespace App\Http\Controllers;

use App\Models\AccountFinance;
use App\Models\Category;
use App\Models\Debit;
use App\Models\FinanceCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debits = Debit::all();
        return view('pages.finance.debit.index', compact('debits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FinanceCategories::all();
        $accounts = AccountFinance::all();
        return view('pages.finance.debit.create', compact(['categories', 'accounts']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "account_finance" => "required",
            "name" => "required",
            "nominal" => "required",
            "debit_date" =>"required|date",
            "category_id" => "required",
            "description" => "required"
        ]);

        Debit::create([
            "name" => $request->name,
            "nominal" => $request->nominal,
            "description" => $request->description,
            "debit_date" => $request->debit_date,
            "account_finance_id" => $request->account_finance,
            "category_id" => $request->category_id,
            "created_by" => Auth::user()->id,
            "updated_by" => Auth::user()->id

        ]);
        return redirect()->route('finance.debit.index')->with('success', 'Debit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Debit $debit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debit $debit)
    {
        $categories = FinanceCategories::all();
        $accounts = AccountFinance::all();
        return view('pages.finance.debit.edit', compact( ['debit', 'categories', 'accounts']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debit $debit)
    {
        $request->validate([
            "account_finance" => "required",
            "name" => "required",
            "nominal" => "required",
            "debit_date" =>"required|date",
            "category_id" => "required",
            "description" => "required"
        ]);
        $debit->name = $request->name;
        $debit->nominal = $request->nominal;
        $debit->description = $request->description;
        $debit->debit_date = $request->debit_date;
        $debit->account_finance_id = $request->account_finance_id;
        $debit->category_id = $request->category_id;
        $debit->created_by = Auth::user()->id;
        $debit->updated_by = Auth::user()->id;
        $debit->save();

        return redirect()->route('finance.debit.index')->with('success', 'Debit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debit $debit)
    {
        $debit->delete();
        return redirect()->route('finance.debit.index')->with('success', 'Debit deleted successfully');

    }
}
