<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'unit',
        'price',
        'stock',
    ];

    // Relasi: Product punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
