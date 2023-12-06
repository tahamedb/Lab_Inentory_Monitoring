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
        $csv = Reader::createFromPath('/Users/abc/Downloads/STOCK 2023 - Copie - réf (1).csv', 'r');
        $csv->setHeaderOffset(0); // If your CSV has headers
            $i=0;
        foreach ($csv as $record) {
            $i=$i+1;
            if($i==30) break;
            Product::create([
                'name' => $record['Produit '],
                'safety_stock_level' => $record['safety_stock']
            ]);
        }
    }
}
