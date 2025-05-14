<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengadaan</title>
    <style>
        /* Landscape orientation */
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 20px;  /* Slightly larger heading */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12px;  /* Slightly larger font size */
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd; /* Added border for better readability */
        }

        th {
            font-weight: bold;
        }

        td {
            background-color: #ffffff; /* No background color */
        }

        /* Adjust column widths and word wrapping */
        th, td {
            word-wrap: break-word;
            max-width: 120px;  /* Adjusted width */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Styling for table rows */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Make the table fit the page in landscape mode */
        .table-container {
            overflow-x: auto;
        }

    </style>
</head>
<body>
    <h1>Data Pengadaan</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Unsur</th>
                    <th>Fungsi</th>
                    <th>No PRK</th>
                    <th>No Kontrak</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Jangka Waktu</th>
                    <th>Vendor Pelaksana</th>
                    <th>Nilai Kontrak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataPengadaan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->unsur->nama ?? '-' }}</td>
                        <td>{{ $item->fungsi->nama ?? '-' }}</td>
                        <td>{{ $item->renev->no_prk ?? '-' }}</td>
                        <td>{{ $item->no_kontrak ?? '-' }}</td>
                        <td>{{ $item->judul_kontrak ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kontrak)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->jangka_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($item->jangka_akhir)->format('d-m-Y') }}</td>
                        <td>{{ $item->vendor_pelaksana ?? '-' }}</td>
                        <td>Rp{{ number_format($item->nilai_kontrak, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
