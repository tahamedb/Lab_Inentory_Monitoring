<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiryAlert extends Model
{
    protected $fillable = ['product_entry_id', 'expiry_date', 'notified'];

    public function productEntry()
    {
        return $this->belongsTo(ProductEntry::class);
    }
}
