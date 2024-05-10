<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ProductsImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'safety_stock_level' => $row[1] ?? 0,

        ]);
    }
}
