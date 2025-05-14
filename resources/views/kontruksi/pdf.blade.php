<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kontruksi</title>
    <style>
        /* Make text smaller */
        body {
            font-size: 10pt; /* Set the font size to 10pt for all text */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 6px; /* Reduced padding for smaller text */
            text-align: left;
        }

        /* Center the title */
        h1 {
            text-align: center;
            font-size: 14pt; /* Set a larger font size for the title */
        }
    </style>
</head>
<body>
    <h1>Laporan Data Kontruksi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pekerjaan</th>
                <th>Nilai Kontrak</th>
                <th>Tanggal Terkontrak</th>
                <th>Progres %</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kontruksi as $kontruksiItem)
                <tr>
                    <td>{{ $kontruksiItem->id }}</td>
                    <td>{{ $kontruksiItem->pekerjaan }}</td>
                    <td>Rp{{ number_format($kontruksiItem->pengadaan ? $kontruksiItem->pengadaan->nilai_kontrak : 0, 0, ',', '.') }}</td>
                    <td>{{ $kontruksiItem->pengadaan ? \Carbon\Carbon::parse($kontruksiItem->pengadaan->tanggal_kontrak)->format('d-m-Y') : 'N/A' }}</td>
                    <td>{{ $kontruksiItem->progres }}%</td>
                    <td>{{ $kontruksiItem->keterangan ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
