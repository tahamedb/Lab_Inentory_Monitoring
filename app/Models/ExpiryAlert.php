<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiryAlert extends Model
{
    protected $fillable = ['product_id', 'expiry_date', 'notified'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}