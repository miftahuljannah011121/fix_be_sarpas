<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Pengembalian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalians as $pengembalian)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengembalian->peminjaman->nama_peminjam ?? $pengembalian->peminjaman->user->name }}</td>
                <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                <td>{{ $pengembalian->jumlah }}</td>
                <td>{{ $pengembalian->tanggal_dikembalikan }}</td>
                <td>{{ ucfirst($pengembalian->status) }}</td>
                <td>Rp{{ number_format($pengembalian->total_denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
