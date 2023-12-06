<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Breeze Authentication Routes
require __DIR__.'/auth.php';
Route::get('/', function () {
    return view('welcome');
});


// Home Route - Redirect to Products Page


// Product Routes
Route::middleware(['auth'])->group(function () {
    // For displaying the list of products (GET request)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // For handling the form submission to create a new product (POST request)
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');


});

// Transaction Routes
Route::middleware(['auth'])->group(function () {
    // For displaying the list of transactions (GET request)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // For handling the form submission to create a new transaction (POST request)
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');

});

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
     ->name('logout');
     
     //i added this bcz logout didnt work b4
     Route::get('logout', function ()
     {
         auth()->logout();
         Session()->flush();
     
         return Redirect::to('/');
     })->name('logout');