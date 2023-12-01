<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'safety_stock_level'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }}
