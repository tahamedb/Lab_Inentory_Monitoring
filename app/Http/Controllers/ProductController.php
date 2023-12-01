<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products from the database
        return view('products.index', compact('products')); // Return a view and pass the products
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
