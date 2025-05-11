<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Renev PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px; /* Reduced font size */
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px; /* Smaller header font */
            font-weight: bold;
            text-transform: uppercase;
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
            font-size: 10px;
        }

        th, td {
            padding: 5px; /* Reduced padding */
            text-align: center;
        }

        td {
            font-size: 9px; /* Smaller font size for data */
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Style for page breaks to ensure content doesn't overflow */
        .page-break {
            page-break-before: always;
        }

        /* Making sure content fits within the page */
        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .table-header {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
            }
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
                    <td>{{ $data['unsur'] ?? 'N/A' }}</td>
                    <td>{{ $data['fungsi'] ?? 'N/A' }}</td>
                    <td>{{ $data['pekerjaan'] ?? 'N/A' }}</td>
                    <td>{{ $data['satuan'] ?? 'N/A' }}</td>
                    <td>{{ $data['volume'] ?? 'N/A' }}</td>
                    <td>{{ isset($data['total_material']) ? number_format($data['total_material'], 0, ',', '.') : 'N/A' }}</td>
                    <td>{{ isset($data['total_jasa']) ? number_format($data['total_jasa'], 0, ',', '.') : 'N/A' }}</td>
                    <td>{{ isset($data['jumlah_pagu']) ? number_format($data['jumlah_pagu'], 0, ',', '.') : 'N/A' }}</td>
                    <td>{{ $data['no_skko'] ?? 'N/A' }}</td>
                    <td>{{ $data['no_prk'] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
