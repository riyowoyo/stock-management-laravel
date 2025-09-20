<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, LogsActivity;

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
    
        public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->causer_id = 1; // user_id 1 selalu sebagai causer
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_id', 'type', 'quantity', 'description', 'date'])
            ->logOnlyDirty()    
            ->setDescriptionForEvent(fn(string $eventName) => "Transaction {$eventName}");
    }
}
