<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ExpiryAlert;
use Illuminate\Http\Request;
use App\Models\LowStockAlert;
use Illuminate\Support\Facades\c;

class ProductController extends Controller
{
    public function index()
    {
        $perPage = 15; // Define items per page this is a new branch
    
        // Fetch and paginate data
        $products = Product::with(['transactions'])->latest()->get();
    
        // Transform the collection within the Paginator
        $products->transform(function ($product) {
            $entries = $product->transactions->where('type', 'entry')->sum('quantity');
            $exits = $product->transactions->where('type', 'exit')->sum('quantity');
            $product->current_stock = $entries - $exits; // Calculate current stock
            return $product;
        });
    
        return view('products.index', compact('products'));
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
            'safety_stock_level' => 'nullable|integer',
            'price' => 'nullable|numeric'
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with([
            'message' => 'Product updated added.',
            'alert-type' => 'success'
        ]); // Redirect to the list of products
    }
    public function edit(Product $product)
    { 
        return view('products.edit', compact('product')); // Return a view for editing the product
    }


    public function update(Request $request, $id)
    {
        // Find the existing transaction by ID
        $product = Product::find($id);
    
        // Check if the product exists
        if (!$product) {
            return redirect()->route('products.index')->withErrors(['product' => 'The selected product does not exist.']);
        }
    
        // Validate other request data
        $validatedData = $request->validate([
            'name' => 'required',
            'safety_stock_level' => 'integer',
            'description' => 'nullable|string',
             'price' => 'nullable|numeric'
        ]);
    
        // Update product properties
        $product->name = $validatedData['name'];
        $product->safety_stock_level = $validatedData['safety_stock_level'];
        
            $product->safety_stock_level = $validatedData['safety_stock_level'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        // Save the updated product
        $product->save();
    
        // Redirect to the products list with a success message
        return redirect()->route('products.index')->with([
            'message' => 'Product updated added.',
            'alert-type' => 'success'
        ]);
    }
    public static function is_below_safety_stock_level($product){
        $entries = $product->transactions->where('type', 'entry')->sum('quantity');
        $exits = $product->transactions->where('type', 'exit')->sum('quantity');
        $product->current_stock = $entries - $exits; // Calculate current stock
        if($product->current_stock < $product->safety_stock_level){
            return true;
        }
        return false;
    }


    public function showAlerts()
{
    $alerts = LowStockAlert::with('product')->where('resolved', false)->get();
    $alerts1 = ExpiryAlert::with('product')->where('notified', true)->get();

    return view('low_stock_alerts', ['StockAlerts' => $alerts , 'ExpiryAlerts' => $alerts1]);
}

    public function destroy($id)
{
    $product = Product::find($id);

    if ($product) {
        $product->delete();
        return redirect()->route('products.index')->with('message', 'product deleted successfully');
    } else {
        return redirect()->route('products.index')->with('message', 'product not found');
    }
}
}
