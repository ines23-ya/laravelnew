{{-- Ini untuk file PDF --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PDF Laporan Pembayaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Pembayaran Keuangan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Kontrak</th>
                <th>Jumlah Pembayaran</th>
                <th>Progres</th>
                <th>Keterangan</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaran as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['no_kontrak'] }}</td>
                    <td>Rp {{ number_format($item['jumlah_pembayaran'], 0, ',', '.') }}</td>
                    <td>{{ $item['progres'] }}%</td>
                    <td>{{ $item['keterangan'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['tanggal_upload'])->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
