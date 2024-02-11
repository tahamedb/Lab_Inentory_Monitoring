<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TransactionController;

// Breeze Authentication Routes
require __DIR__.'/auth.php';
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashtest', [HomeController::class, 'index'])->name('dashtest');

// Home Route - Redirect to Products Page

Route::get('/sendmail', [MailController::class, 'SendMail']);
// Product Routes




Route::middleware(['auth'])->group(function () {
    // For displaying the list of products (GET request)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // For handling the form submission to create a new product (POST request)
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('/low-stock-alerts', [ProductController::class, 'showAlerts'])->name('products.low-stock-alerts');


    Route::get('/home', [HomeController::class, 'index'])->name('home.index');
// Route::get('/dashtest', function () {
//     return view('admin.index');
// });


});

// Transaction Routes
Route::middleware(['auth'])->group(function () {
    // For displaying the list of transactions (GET request)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // For handling the form submission to create a new transaction (POST request)
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.delete');


});


Route::middleware(['auth'])->group(function () {
    // For displaying the list of transactions (GET request)
    Route::get('/profile', [ProfileController::class, 'UserProfile'])->name('admin.profile');
    Route::post('/profile/store', [ProfileController::class, 'UserProfileStore'])->name('admin.profile.store');

   
});
// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
     ->name('logout');
     
     // //i added this bcz logout didnt work b4
     // Route::get('logout', function ()
     // {
     //     auth()->logout();
     //     Session()->flush();
     
     //     return Redirect::to('/login');
     // })->name('logout');