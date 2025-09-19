<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'description',
        'date',
    ];

    // Relasi: Transaction milik satu Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Transaction milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
