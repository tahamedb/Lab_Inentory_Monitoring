<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntry extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = ['product_id', 'quantity', 'expiry_date'];

    // The attributes that should be cast to native types.
    protected $casts = [
        'expiry_date' => 'datetime',  // Ensure expiry_date is handled as a Carbon instance
    ];

    /**
     * Get the product associated with the product entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the expiry alerts associated with the product entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expiryAlerts()
    {
        return $this->hasMany(ExpiryAlert::class);
    }
}
