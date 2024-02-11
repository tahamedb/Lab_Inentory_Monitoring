<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntry extends Model
{
    protected $fillable = ['product_id', 'quantity', 'expiry_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}