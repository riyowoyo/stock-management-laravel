<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: center;
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
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td.text-center {
            text-align: center;
        }

        td.text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h3>Laporan Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Type</th>
                <th class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $t->product->product_code }}</td>
                <td>{{ $t->product->name }}</td>
                <td>{{ $t->description }}</td>
                <td class="text-center">{{ $t->quantity }}</td>
                <td class="text-center">{{ strtoupper($t->type) }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
