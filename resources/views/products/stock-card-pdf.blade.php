<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Stok - {{ $product->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        td.text-right {
            text-align: right;
        }

        .text-success { color: green; }
        .text-danger { color: red; }
    </style>
</head>
<body>
    <h3>Kartu Stok: {{ $product->name }} ({{ $product->product_code }})</h3>
    <p><strong>Harga Satuan:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Masuk (Unit)</th>
                <th>Keluar (Unit)</th>
                <th>Harga Satuan</th>
                <th>Saldo Unit</th>
                <th>Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $saldoUnit = 0;
                $saldoRupiah = 0;
            @endphp

            @forelse ($transactions as $trx)
                @php
                    $nominal = $trx->quantity * $product->price;
                    if ($trx->type === 'in') {
                        $saldoUnit += $trx->quantity;
                        $saldoRupiah += $nominal;
                    } else {
                        $saldoUnit -= $trx->quantity;
                        $saldoRupiah -= $nominal;
                    }
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                    <td>{{ $trx->description }}</td>
                    <td class="text-success">{{ $trx->type === 'in' ? $trx->quantity : '' }}</td>
                    <td class="text-danger">{{ $trx->type === 'out' ? $trx->quantity : '' }}</td>
                    <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $saldoUnit }}</td>
                    <td class="text-right">Rp {{ number_format($saldoRupiah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada transaksi untuk produk ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
