<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Filter by product name if provided
        if ($request->has('product_name') && $request->product_name != '') {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product_name . '%');
            });
        }

        // Filter by user name if provided
        if ($request->has('user_name') && $request->name != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $transactions = $query->get();
        $products = Product::all(); // Assuming you have a Product model

        return view('transactions.index', compact('transactions', 'products'));
    }

    
    public function store(Request $request)
    {
        $user = Auth::user();

        // Assume the field for product name in the form is 'product_name'
        $productName = $request->input('product_name');
    
        // Find the product by name
        $product = Product::where('name', $productName)->first();
    
        // Check if product exists
        if (!$product) {
            return back()->withErrors(['product_name' => 'The selected product does not exist.'])->withInput();
        }
    
        // Validate other request data
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:entry,exit',
            'remarks' => 'nullable|string'
        ]);
    
        // Add product_id to the validated data
        $validatedData['product_id'] = $product->id;
        $validatedData['user_id'] = $user->id;
    $validatedData['user_name'] = $user->name;
    
        // Create and save the new transaction
        Transaction::create($validatedData);
    
        // Redirect to the transactions list with a success message
        return redirect()->route('transactions.index')->with('success', 'Transaction successfully added.');
    }
}