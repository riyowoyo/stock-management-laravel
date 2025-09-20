<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Qty</th>
                <th>Type</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $t->product->product_code }}</td>
                <td>{{ $t->product->name }}</td>
                <td>{{ $t->description }}</td>
                <td>{{ $t->quantity }}</td>
                <td>{{ strtoupper($t->type) }}</td>
                <td>{{ $t->date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
