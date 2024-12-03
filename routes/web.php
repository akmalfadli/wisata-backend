<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardFinanceController;
use App\Http\Controllers\AccountFinanceController;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::get('/auth-register', [RegisterController::class, 'index'])->name('auth-register');
Route::middleware(['auth'])->group(function () {
    Route::get('/home',[DashboardController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    //Route::resource('orders', OrderController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id} ', [OrderController::class, 'show'])->name('orders.show');

    Route::get('keuangan', [DashboardFinanceController::class, 'index'])->name('keuangan');

    Route::get('/keuangan/category', [FinanceCategoriesController::class, 'index'])->name('finance.categories.index');
    Route::get('/keuangan/category/create', [FinanceCategoriesController::class, 'create'])->name('finance.categories.create');
    Route::post('/keuangan/category/create', [FinanceCategoriesController::class, 'store'])->name('finance.categories.store');
    Route::delete('/keuangan/category/delete/{id}', [FinanceCategoriesController::class, 'destroy'])->name('finance.categories.destroy');
    Route::get('/keuangan/category/edit/{category}', [FinanceCategoriesController::class, 'edit'])->name('finance.categories.edit');
    Route::put('/keuangan/category/update/{category}', [FinanceCategoriesController::class, 'update'])->name('finance.categories.update');

    Route::get('keuangan/masuk', [CreditController::class, 'index'])->name('finance.credit.index');
    Route::get('keuangan/masuk/create', [CreditController::class, 'create'])->name('finance.credit.create');
    Route::post('keuangan/masuk/store', [CreditController::class, 'store'])->name('finance.credit.store');
    Route::get('keuangan/masuk/edit/{credit}', [CreditController::class, 'edit'])->name('finance.credit.edit');
    Route::put('keuangan/masuk/update/{credit}', [CreditController::class, 'update'])->name('finance.credit.update');
    Route::delete('/keuangan/credit/delete/{credit}', [CreditController::class, 'destroy'])->name('finance.credit.destroy');

    Route::get('keuangan/keluar', [DebitController::class, 'index'])->name('finance.debit.index');
    Route::get('keuangan/keluar/create', [DebitController::class, 'create'])->name('finance.debit.create');
    Route::post('keuangan/keluar/store', [DebitController::class, 'store'])->name('finance.debit.store');
    Route::get('keuangan/keluar/edit/{debit}', [DebitController::class, 'edit'])->name('finance.debit.edit');
    Route::put('keuangan/keluar/update/{debit}', [DebitController::class, 'update'])->name('finance.debit.update');
    Route::delete('/keuangan/keluar/delete/{debit}', [DebitController::class, 'destroy'])->name('finance.debit.destroy');

    Route::get('keuangan/akun', [AccountFinanceController::class, 'index'])->name('finance.account.index');
    Route::get('keuangan/akun/create', [AccountFinanceController::class, 'create'])->name('finance.account.create');
    Route::post('keuangan/akun/store', [AccountFinanceController::class, 'store'])->name('finance.account.store');
    Route::get('keuangan/akun/edit', [AccountFinanceController::class, 'edit'])->name('finance.account.edit');
    Route::delete('/keuangan/akun/delete/{credit}', [AccountFinanceController::class, 'destroy'])->name('finance.account.destroy');
});
