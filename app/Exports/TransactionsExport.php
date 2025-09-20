<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $type;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function collection()
    {
        $query = Transaction::with('product')->select('product_id', 'quantity', 'type', 'description', 'date');

        if ($this->type) {
            $query->where('type', $this->type);
        }

        return $query->get()->map(function ($t) {
            return [
                'Kode Barang'   => $t->product->product_code,
                'Nama Barang'   => $t->product->name,
                'Deskripsi'     => $t->description,
                'Qty'           => $t->quantity,
                'Type'          => $t->type == 'in' ? 'Masuk' : 'Keluar',
                'Tanggal'       => $t->date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Deskripsi',
            'Qty',
            'Type',
            'Tanggal',
        ];
    }
}
