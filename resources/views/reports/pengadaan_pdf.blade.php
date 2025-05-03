<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengadaan (PDF)</title>
    <style>
        @page {
            margin: 10px;
            size: A4 landscape; /* Landscape supaya tabel panjang muat */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Ukuran font kecil */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Pengadaan</h2>

    <table>
        <thead>
            <tr>
                <th>Unsur</th>
                <th>Fungsi</th>
                <th>No PRK</th>
                <th>No Kontrak</th>
                <th>Judul Kontrak</th>
                <th>Tanggal Kontrak</th>
                <th>Vendor Pelaksana</th>
                <th>Nilai Kontrak (Rp)</th>
                <th>Jangka Waktu (hari)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_pbj as $data)
            <tr>
                <td>{{ $data['unsur'] ?? '-' }}</td>
                <td>{{ $data['fungsi'] ?? '-' }}</td>
                <td>{{ $data['no_prk'] ?? '-' }}</td>
                <td>{{ $data['no_kontrak'] ?? '-' }}</td>
                <td>{{ $data['judul_kontrak'] ?? '-' }}</td>
                <td>{{ isset($data['tanggal_kontrak']) ? \Carbon\Carbon::parse($data['tanggal_kontrak'])->format('d-m-Y') : '-' }}</td>
                <td>{{ $data['vendor_pelaksana'] ?? '-' }}</td>
                <td>{{ isset($data['nilai_kontrak']) ? number_format($data['nilai_kontrak'], 0, ',', '.') : '-' }}</td>
                <td>{{ $data['jangka_waktu'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
