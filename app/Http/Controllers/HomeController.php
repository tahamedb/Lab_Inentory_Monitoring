<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('transactions')->get();

        // Dynamically calculate current stock for each product
        $products->each(function ($product) {
            $entries = $product->transactions->where('type', 'entry')->sum('quantity');
            $exits = $product->transactions->where('type', 'exit')->sum('quantity');
            $product->current_stock = $entries - $exits;
        });

        $lowStockProducts = $products->filter(function ($product) {
            return $product->current_stock < $product->safety_stock_level;
        });

        $recentTransactions = Transaction::latest()->take(10)->with('product')->get();

        return view('home', compact('lowStockProducts', 'recentTransactions', 'products'));
    }
}

