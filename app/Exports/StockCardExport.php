<?php 

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockCardExport implements FromArray, WithHeadings
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function array(): array
    {
        $rows = [];
        $saldoUnit = 0;
        $saldoRupiah = 0;

        foreach ($this->product->transactions()->orderBy('date')->orderBy('created_at')->get() as $trx) {
            $nominal = $trx->quantity * $this->product->price;

            if ($trx->type === 'in') {
                $saldoUnit += $trx->quantity;
                $saldoRupiah += $nominal;
            } else {
                $saldoUnit -= $trx->quantity;
                $saldoRupiah -= $nominal;
            }

            $rows[] = [
                $trx->date,
                $trx->description,
                $trx->type === 'in' ? $trx->quantity : '',
                $trx->type === 'out' ? $trx->quantity : '',
                $this->product->price,
                $saldoUnit,
                $saldoRupiah
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Deskripsi',
            'Masuk (Unit)',
            'Keluar (Unit)',
            'Harga Satuan',
            'Saldo Unit',
            'Saldo (Rp)'
        ];
    }
}
