<?php

namespace App\Models;

use App\Models\ExpiryAlert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'safety_stock_level', 'price', 'expiry_date', 'created_at', 'low_stock_email_sent'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function expiryAlerts()
    {
        return $this->hasMany(ExpiryAlert::class);
    }
    public function productEntries()
    {
        return $this->hasMany(ProductEntry::class);
    }
}
