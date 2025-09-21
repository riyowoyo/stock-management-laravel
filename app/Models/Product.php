<?php

namespace App\Models;

use id;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
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

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->causer_id = auth()->id();

        // Info tambahan yang selalu muncul
        $activity->properties = [
            'Kode Produk' => $this->product_code,
            'Nama Produk' => $this->name,
            'Satuan'      => $this->unit,
            'Harga'       => number_format($this->price, 0, ',', '.'),
            'Stok'        => $this->stock,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('product_audit')
            ->logOnly(['product_code', 'name', 'unit', 'price', 'stock'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "Produk baru telah ditambahkan: {$this->name} ({$this->product_code})",
                    'updated' => "Produk {$this->name} ({$this->product_code}) telah diperbarui",
                    'deleted' => "Produk {$this->name} ({$this->product_code}) telah dihapus",
                    default   => "Produk {$this->name} ({$this->product_code}) mengalami perubahan",
                };
            });
    }
}
