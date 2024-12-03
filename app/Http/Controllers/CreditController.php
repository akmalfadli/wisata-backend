<?php

namespace App\Http\Controllers;

use App\Models\AccountFinance;
use App\Models\Category;
use App\Models\Credit;
use App\Models\FinanceCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credits = Credit::all();
        return view('pages.finance.credit.index', compact('credits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FinanceCategories::all();
        $accounts = AccountFinance::all();
        return view('pages.finance.credit.create', compact(['categories', 'accounts']));
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
            "credit_date" =>"required|date",
            "category_id" => "required",
            "description" => "required"
        ]);

        //dd($request->account_finance);
        Credit::create([
            "name" => $request->name,
            "nominal" => $request->nominal,
            "description" => $request->description,
            "credit_date" => $request->credit_date,
            "account_finance_id" => $request->account_finance,
            "category_id" => $request->category_id,
            "created_by" => Auth::user()->id,
            "updated_by" => Auth::user()->id

        ]);
        return redirect()->route('finance.credit.index')->with('success', 'Credit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Credit $credit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Credit $credit)
    {
        $categories = FinanceCategories::all();
        $accounts = AccountFinance::all();
        return view('pages.finance.credit.edit', compact( ['credit', 'categories', 'accounts']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Credit $credit)
    {
        $request->validate([
            "account_finance" => "required",
            "name" => "required",
            "nominal" => "required",
            "credit_date" =>"required|date",
            "category_id" => "required",
            "description" => "required"
        ]);

        $credit->name = $request->name;
        $credit->nominal = $request->nominal;
        $credit->description = $request->description;
        $credit->credit_date = $request->credit_date;
        $credit->account_finance_id = $request->account_finance_id;
        $credit->category_id = $request->category_id;
        $credit->created_by = Auth::user()->id;
        $credit->updated_by = Auth::user()->id;
        $credit->save();

        return redirect()->route('finance.credit.index')->with('success', 'Credit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit)
    {
        $credit->delete();
        return redirect()->route('finance.credit.index')->with('success', 'Credit deleted successfully');

    }
}
