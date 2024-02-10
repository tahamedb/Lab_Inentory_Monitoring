<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowStockAlert extends Model
{
    // The table associated with the model.
    protected $table = 'low_stock_alerts';

    // The attributes that are mass assignable.
    protected $fillable = [
        'product_id',
        'resolved'
    ];

    /**
     * Get the product associated with the low stock alert.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
