<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        $users = DB::table('users')->when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('email', 'like', "%{$request->keyword}%")
                ->orWhere('phone', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);
        $products = Product::all();
        return view('pages.users.index', compact(['users','products']));
    }

    //create
    public function create()
    {
        $products = Product::all();
        return view('pages.users.create', compact('products'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required',
            'role' => 'required',
        ]);

        $selectedValues = isset($_POST['product']) ? $_POST['product'] : [];
        //dd($selectedValues);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Ensure password is hashed
            'phone' => $request->phone,
            'role' => $request->role,
            'allowed' => json_encode(array_map('intval', $selectedValues))
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    //edit
    public function edit(User $user)
    {
        $products = Product::all();
        return view('pages.users.edit', compact(['user', 'products']));
    }

    //update
    public function update(Request $request, User $user)
    {
        $selectedValues = isset($_POST['product']) ? $_POST['product'] : [];
        //dd($selectedValues);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->allowed = array_map('intval', $selectedValues);
        $user->save();

        //check if phone is not empty
        if ($request->phone) {
            $user->update(['phone' => $request->phone]);
        }
        //check if password is not empty
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    //destroy
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
