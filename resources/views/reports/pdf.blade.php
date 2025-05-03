<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Renev PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>LAPORAN DATA RENEV</h2>

    <table>
        <thead>
            <tr>
                <th>Unsur</th>
                <th>Fungsi</th>
                <th>Pekerjaan</th>
                <th>Satuan</th>
                <th>Volume</th>
                <th>Total Material (Rp)</th>
                <th>Total Jasa (Rp)</th>
                <th>Jumlah Pagu (Rp)</th>
                <th>SKKO</th>
                <th>No PRK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($renevData as $data)
                <tr>
                    <td>{{ $data['unsur'] ?? '-' }}</td>
                    <td>{{ $data['fungsi'] ?? $data['fungsi_manual'] ?? '-' }}</td>
                    <td>{{ $data['pekerjaan'] ?? '-' }}</td>
                    <td>{{ $data['satuan'] ?? '-' }}</td>
                    <td>{{ $data['volume'] ?? '-' }}</td>
                    <td>{{ isset($data['total_material']) ? number_format($data['total_material'], 0, ',', '.') : '-' }}</td>
                    <td>{{ isset($data['total_jasa']) ? number_format($data['total_jasa'], 0, ',', '.') : '-' }}</td>
                    <td>{{ isset($data['jumlah_pagu']) ? number_format($data['jumlah_pagu'], 0, ',', '.') : '-' }}</td>
                    <td>{{ $data['no_skko'] ?? '-' }}</td>
                    <td>{{ $data['no_prk'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
