<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        {
            $products = Product::with(['transactions'])->get()->map(function ($product) {
                $entries = $product->transactions->where('type', 'entry')->sum('quantity');
                $exits = $product->transactions->where('type', 'exit')->sum('quantity');
                $product->current_stock = $entries - $exits; // Calculate current stock
                return $product;
            });
    
            return view('products.index', compact('products'));
        }
    }
    public function create()
    {
        return view('products.create'); // Return a view for creating a new product
    }

    public function store(Request $request)
    {
        // Validate and store the new product
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'safety_stock_level' => 'required|integer',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index'); // Redirect to the list of products
    }
}
