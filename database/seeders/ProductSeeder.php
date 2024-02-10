<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = Product::all();
        $currentYear = date('Y');

        foreach ($products as $product) {
            // Generate a random price between 30 and 400
            $product->price = rand(30, 400);

            // Generate a random expiry date within the current year
            $month = rand(1, 12);
            $day = rand(1, 28); // Keeping it 28 to avoid invalid dates
            $expiryDate = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            $product->expiry_date = $expiryDate;

            $product->save();
        }
    }
}
