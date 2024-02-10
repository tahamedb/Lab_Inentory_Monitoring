<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\LowStockAlert;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Filter by product name if provided
        // if ($request->has('product_name') && $request->product_name != '') {
        //     $query->whereHas('product', function ($q) use ($request) {
        //         $q->where('name', 'like', '%' . $request->product_name . '%');
        //     });
        // }

        // Filter by user name if provided
        if ($request->has('user_name') && $request->name != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
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
        $entries = $product->transactions()->where('type', 'entry')->sum('quantity');
        $exits = $product->transactions()->where('type', 'exit')->sum('quantity');
        $currentStock = $entries - $exits;
    
        // Check for 'exit' transaction if it exceeds current stock
        if ($validatedData['type'] == 'exit' && $validatedData['quantity'] > $currentStock) {
            return back()->with([
                'message' => 'The quantity for the exit transaction exceeds the current stock:'. $currentStock,
                'alert-type' => 'error'
            ]);
        }
        // Add product_id to the validated data
        $validatedData['product_id'] = $product->id;
        $validatedData['user_id'] = $user->id;
        $validatedData['user_name'] = $user->name;

        // If the transaction type is 'entry', validate the expiry date
        if ($request->input('type') === 'entry') {
            $validatedData['expiry_date'] = $request->validate([
                'expiry_date' => 'required|date'
            ])['expiry_date'];

            // Update the product's expiry date
            $product->expiry_date = $validatedData['expiry_date'];
            $product->save();
        }

        // Create and save the new transaction
        Transaction::create($validatedData);

        //check if product is below safety stock level and send email

 // Recalculate the current stock
    $entries = $product->transactions()->where('type', 'entry')->sum('quantity');
    $exits = $product->transactions()->where('type', 'exit')->sum('quantity');
    $currentStock = $entries - $exits;

    // Check if product is below safety stock level and send email
    if ($currentStock < $product->safety_stock_level && !$product->low_stock_email_sent) {
        $mailController = new MailController();
        $mailController->send_low_stock_mail($product);
        $product->low_stock_email_sent = true;
        $product->save();
        LowStockAlert::create(['product_id' => $product->id]);

    }

    if ($currentStock > $product->safety_stock_level) {
        if ($product->low_stock_email_sent) {
            $product->low_stock_email_sent = false;
            $product->save();
        }

        // Find any unresolved low stock alert for this product and mark as resolved
        $unresolvedAlert = LowStockAlert::where('product_id', $product->id)
                                         ->where('resolved', false)
                                         ->first();
        if ($unresolvedAlert) {
            $unresolvedAlert->resolved = true;
            $unresolvedAlert->save();
        }
    }

        // Redirect to the transactions list with a success message
        return redirect()->route('transactions.index')->with([
            'message' => 'Transaction successfully added.',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        return view('transactions.edit', compact('transaction', 'products'));
    }
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Find the existing transaction by ID
        $transaction = Transaction::find($id);

        // Check if the transaction exists
        if (!$transaction) {
            return redirect()->route('transactions.index')->withErrors(['transaction' => 'The selected transaction does not exist.']);
        }

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

        if ($request->input('type') === 'entry') {
            $validatedData['expiry_date'] = $request->validate([
                'expiry_date' => 'required|date'
            ])['expiry_date'];

            // Update the product's expiry date
            $product->expiry_date = $validatedData['expiry_date'];
            $product->save();
        }

        // Update transaction properties
        $transaction->product_id = $product->id;
        $transaction->quantity = $validatedData['quantity'];
        $transaction->type = $validatedData['type'];
        $transaction->remarks = $validatedData['remarks'];

        // Save the updated transaction
        $transaction->save();

        // Redirect to the transactions list with a success message
        return redirect()->route('transactions.index')->with([
            'message' => 'Transaction successfully updated.',
            'alert-type' => 'success'
        ]);
    }
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->delete();
            return redirect()->route('transactions.index')->with('message', 'Transaction deleted successfully');
        } else {
            return redirect()->route('transactions.index')->with('message', 'Transaction not found');
        }
    }
}
