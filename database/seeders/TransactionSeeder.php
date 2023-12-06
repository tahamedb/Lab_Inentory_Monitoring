<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Product;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Get all products
        $products = Product::all();

        // Define user_name, user_id, remarks, and type
        $user_name = 'taha';
        $user_id = 1;
        $remarks = 'none';
        $type = 'entry';

        foreach ($products as $product) {
            $quantity = 30; // Generate a random quantity (adjust the range as needed)

            Transaction::create([
                'product_id' => $product->id,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'type' => $type,
                'quantity' => $quantity,
                'remarks' => $remarks,
            ]);
        }
    }
}

