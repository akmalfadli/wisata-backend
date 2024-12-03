<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FinanceCategories;
use Illuminate\Support\Facades\Auth;

class FinanceCategoriesController extends Controller{

    public function index(Request $request)
    {
        $categories = FinanceCategories::when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('description', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.finance.categories.index', compact('categories'));
    }

    //create
    public function create()
    {

        return view('pages.finance.categories.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'transaction_type' => 'required'
        ]);

        FinanceCategories::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->transaction_type,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        return redirect()->route('finance.categories.index')->with('success', 'Category created successfully');
    }

    //edit
    public function edit(FinanceCategories $category)
    {
        return view('pages.finance.categories.edit', compact('category'));
    }

    //update
    public function update(Request $request, FinanceCategories $category)
    {

       // dd($request->transaction_type);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->type = $request->transaction_type;
        $category->save();

        return redirect()->route('finance.categories.index')->with('success', 'Category updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        //dd($id);
        $categories = FinanceCategories::find($id);
        $categories->delete();
        return redirect()->route('finance.categories.index')->with('success', 'Category deleted successfully');
    }
}
