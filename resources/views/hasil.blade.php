<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Renev</title>
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
            margin-bottom: 10px;
            text-align: center;
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
            margin-bottom: 20px;
            text-align: left;
        }

        .back-link {
            color: #091057;
            font-weight: bold;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .back-link:hover {
            text-decoration: underline;
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
        <li><a href="{{ route('halrenev') }}">Renev</a></li>
        
        <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Reports</a></li>
   
        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</nav>

<div class="container">
    <div class="header-bar">
        <h2>Hasil Input Renev</h2>
    </div>

    <div class="back-link-wrapper">
        <a href="{{ route('halrenev') }}" class="back-link">← Kembali ke Halaman Renev</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Unsur</th>
                <th>Fungsi</th>
                <th>No PRK</th>
                <th>SKKO</th>
                <th>Pekerjaan</th>
                <th>Satuan</th>
                <th>Volume</th>
                <th>Total Material (Rp)</th>
                <th>Total Jasa (Rp)</th>
                <th>Jumlah Pagu (Rp)</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data['unsur'] ?? '-' }}</td>
                <td>{{ $data['fungsi'] ?? '-' }}</td>
                <td>{{ $data['no_prk'] ?? '-' }}</td>
                <td>{{ $data['no_skko'] ?? '-' }}</td>
                <td>{{ $data['pekerjaan'] ?? '-' }}</td>
                <td>{{ $data['satuan'] ?? '-' }}</td>
                <td>{{ $data['volume'] ?? '-' }}</td>
                <td>{{ isset($data['total_material']) ? number_format($data['total_material'], 0, ',', '.') : '-' }}</td>
                <td>{{ isset($data['total_jasa']) ? number_format($data['total_jasa'], 0, ',', '.') : '-' }}</td>
                <td>{{ isset($data['jumlah_pagu']) ? number_format($data['jumlah_pagu'], 0, ',', '.') : '-' }}</td>
            </tr>
        </tbody>
        
    </table>
</div>

</body>
</html>
