<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reports Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background: #12092F;
            padding: 15px 0;
            display: flex;
            justify-content: center;
            position: fixed;
            top: 0;
            width: 100%;
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
            font-weight: bold;
        }

        .container {
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-bar {
            width: 95%;
            max-width: 1200px;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 1px 1px 3px black;
        }

        .btn-download {
            margin-bottom: 20px;
        }

        table {
            background: white;
            border-collapse: collapse;
            width: 95%;
            max-width: 1200px;
        }

        table th, table td {
            border: 1px solid black;
            padding: 8px 10px;
            text-align: center;
        }

        table th {
            background: #eee;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <ul>
        <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
        <li><a href="#">Dashboard</a></li>
        <li><a href="{{ route('keuangan') }}">Keuangan</a></li>
        <li><a href="{{ route('reportskeuangan') }}">Reports</a></li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>

<div class="container">
    <div class="header-bar">
        <h2>Laporan Pembayaran Keuangan</h2>
    </div>

    <!-- Tombol Download -->
    <div class="btn-download text-center">
        <a href="{{ route('export.keuangan.pdf') }}" class="btn btn-danger btn-sm">
            📄 Download PDF
        </a>
        <a href="{{ route('export.keuangan.excel') }}" class="btn btn-success btn-sm">
            📊 Download Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>Jumlah Pembayaran (Rp)</th>
                    <th>Progres (%)</th>
                    <th>Keterangan</th>
                    <th>Tanggal Upload</th>
                    <th>File BA Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data_pembayaran as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['no_kontrak'] }}</td>
                        <td>Rp {{ number_format($item['jumlah_pembayaran'], 0, ',', '.') }}</td>
                        <td>{{ $item['progres'] }}%</td>
                        <td>{{ $item['keterangan'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['tanggal_upload'])->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $item['file_path']) }}" target="_blank" class="btn btn-primary btn-sm">
                                Lihat File
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-danger">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
