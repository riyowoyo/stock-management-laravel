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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->causer_id = auth()->id();

        $product = $this->product ?? Product::withTrashed()->find($this->product_id);

        $tipe = $this->type === 'in' ? 'Barang Masuk' : 'Barang Keluar';

        $activity->properties = [
            'Nama Produk' => $product?->name,
            'Kode Produk' => $product?->product_code,
            'Jumlah'      => $this->quantity . ' ' . $product?->unit,
            'Jenis'       => $tipe,
            'Deskripsi'   => $this->description ?? '-',
            'Tanggal'     => $this->date,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('transaction_audit')
            ->logFillable()
            ->setDescriptionForEvent(function (string $eventName) {
                $productName = $this->product?->name ?? 'Produk';
                $productCode = $this->product?->product_code ?? '-';

                return match ($eventName) {
                    'created' => "Transaksi baru ditambahkan untuk {$productName} ({$productCode})",
                    'updated' => "Transaksi untuk {$productName} ({$productCode}) telah diperbarui",
                    'deleted' => "Transaksi untuk {$productName} ({$productCode}) telah dihapus",
                    default   => "Transaksi untuk {$productName} ({$productCode}) mengalami perubahan",
                };
            });
    }
}
