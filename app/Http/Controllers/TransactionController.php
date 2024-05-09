<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Import Log facade
use App\Models\ProductEntry;
use App\Models\LowStockAlert;
use Illuminate\Support\Facades\DB;
use Exception;

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

        Log::info('Entering store method', ['userID' => Auth::id()]);

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:entry,exit',
            'remarks' => 'nullable|string',

        ]);

        $product = Product::where('name', $request['product_name'])->first();

        if (!$product) {
            Log::error('Product not found', ['product_name' => $request['product_name']]);
            return back()->withErrors(['product_name' => 'The selected product does not exist.'])->withInput();
        }

        if ($validatedData['type'] == 'entry') {
            ProductEntry::create([
                'product_id' => $product->id,
                'quantity' => $validatedData['quantity'],
                'expiry_date' => $request['expiry_date'],
            ]);
            Log::info('Entry transaction processed', ['product_id' => $product->id, 'quantity' => $validatedData['quantity']]);
        } else {
            $remainingQuantity = $validatedData['quantity'];
            $productEntries = ProductEntry::where('product_id', $product->id)
                ->where('quantity', '>', 0)
                ->orderBy('expiry_date', 'asc')
                ->get();

            foreach ($productEntries as $entry) {
                if ($remainingQuantity <= $entry->quantity) {
                    $entry->decrement('quantity', $remainingQuantity);
                    Log::info('Exit transaction processed within one entry', ['productEntryId' => $entry->id, 'decrementedQuantity' => $remainingQuantity]);
                    $remainingQuantity = 0;
                    break;
                } else {
                    $remainingQuantity -= $entry->quantity;
                    $entry->update(['quantity' => 0]);
                    Log::info('Exit transaction processed across multiple entries', ['productEntryId' => $entry->id, 'decrementedQuantity' => $entry->quantity]);
                }
            }

            if ($remainingQuantity > 0) {
                Log::error('Insufficient stock for exit transaction', ['product_id' => $product->id, 'remainingQuantity' => $remainingQuantity]);
                return back()->with([
                    'message' => 'The quantity for the exit transaction exceeds the available stock.',
                    'alert-type' => 'error'
                ]);
            }
        }

        // Low stock alert check logic here...
        Transaction::create(array_merge($validatedData, [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'user_name' => $user->name, // Note: This might not be necessary if you have user_id
        ]));

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
        // this is for when the stock becomes above the safety stock level
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
        Log::info('Transaction completed successfully', ['product_id' => $product->id, 'transaction_type' => $validatedData['type']]);
        return redirect()->route('transactions.index')->with([
            'message' => 'Transaction successfully processed.',
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
