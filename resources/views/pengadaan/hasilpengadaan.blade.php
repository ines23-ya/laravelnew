<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengadaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('{{ asset('assets/bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .navbar {
            background: #12092F;
            padding: 15px 0;
            width: 100%;
            display: flex;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-weight: bold;
        }

        .navbar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .container {
            padding-top: 70px; /* Reduced space from the top */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-title {
            text-align: center;
            width: 100%;
            margin-bottom: 5px; /* Reduced margin */
        }

        h2 {
            color: white;
            font-size: 22px;
            font-weight: bold;
            text-shadow: 1px 1px 3px black;
        }

        .back-link-wrapper {
            width: 95%;
            max-width: 1200px;
            margin-bottom: 10px; /* Reduced space between the link and table */
            text-align: left;
        }

        .back-link {
            font-size: 16px;
            font-weight: bold;
            color: #091057;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Button Styling */
        .btn-download {
            margin-top: 10px; /* Reduced margin from table */
            margin-bottom: 10px; /* Reduced margin */
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .btn-pdf {
            background-color: red;
            color: white;
        }

        .btn-pdf:hover {
            background-color: darkred;
        }

        .btn-excel {
            background-color: green;
            color: white;
        }

        .btn-excel:hover {
            background-color: darkgreen;
        }

        table {
            background: white;
            border-collapse: collapse;
            width: 95%;
            max-width: 1200px;
            margin-bottom: 20px; /* Reduced margin between the table and buttons */
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 8px 10px;
            font-size: 14px;
            text-align: center;
        }

        table th {
            background: #ddd;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ route('pengadaan') }}">Pengadaan</a></li>
            <li><a href="{{ route('pengadaan.reports') }}">Reports</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="header-title">
            <h2>Tabel Pengadaan</h2>
        </div>

        <div class="back-link-wrapper">
            <a href="{{ route('pengadaan') }}" class="back-link">Kembali ke Halaman Pengadaan</a>
        </div>

        <!-- Tombol Download PDF dan Excel -->
        <div class="action-buttons">
            <a href="{{ route('pengadaan.download.pdf') }}" class="btn-download btn-pdf">Download PDF</a>
            <a href="{{ route('pengadaan.download.excel') }}" class="btn-download btn-excel">Download Excel</a>
        </div>

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
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($dataPengadaan->count())
                    @foreach ($dataPengadaan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->unsur->nama ?? '-' }}</td>
                            <td>{{ $item->fungsi->nama ?? '-' }}</td>
                            <td>{{ $item->renev->no_prk ?? '-' }}</td>
                            <td>{{ $item->no_kontrak ?? '-' }}</td>
                            <td>{{ $item->judul_kontrak ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kontrak)->format('d-m-Y') }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->jangka_mulai)->format('d-m-Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($item->jangka_akhir)->format('d-m-Y') }}
                                <br>
                                ({{ \Carbon\Carbon::parse($item->jangka_mulai)->diffInDays($item->jangka_akhir) + 1 }} hari)
                            </td>
                            <td>{{ $item->vendor_pelaksana ?? '-' }}</td>
                            <td>Rp{{ number_format($item->nilai_kontrak, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pbj.download', basename($item->dokumen)) }}">Download</a>
                            </td>
                            <td>
                                <!-- Ikon Edit -->
                                <a href="{{ route('pengadaan.edit', $item->id) }}" class="btn-edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                  
                                <!-- Ikon Delete -->
                                <form action="{{ route('pengadaan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12" style="text-align: center;">Belum ada data pengadaan.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</body>

</html>
