<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        Excel::import(new ProductsImport, '/Users/abc/Downloads/ProductsLabo.xlsx');
    }
}
