<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_code',
        'name',
        'unit',
        'price',
        'stock',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Semua activity pakai user_id = 1 & tambahkan detail produk saat delete
    public function tapActivity(\Spatie\Activitylog\Models\Activity $activity, string $eventName)
    {
        $activity->causer_id = 1; // Hardcode Test User

        if ($eventName === 'deleted') {
            $activity->properties = [
                'name' => $this->name,
                'product_code' => $this->product_code,
                'unit' => $this->unit,
                'price' => $this->price,
                'stock' => $this->stock,
            ];
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','unit','price','stock','product_code'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Produk {$eventName}");
    }
}
