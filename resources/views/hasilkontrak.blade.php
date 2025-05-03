<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kontrak</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            color: black;
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
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            border-collapse: collapse;
            width: 95%;
            background-color: white;
        }

        th, td {
            border: 1px solid #000;
            text-align: center;
            padding: 8px;
            font-size: 14px;
        }

        th {
            background-color: #f8f8f8;
        }

        .btn-group {
            margin-top: 20px;
        }

        .btn-group a {
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            color: white;
        }

        .btn-back {
            background-color: #007bff;
        }

        .btn-edit {
            background-color: #2d6a4f;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <ul>
        <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
        <li><a href="#">Dashboard</a></li>
        <li><a href="{{ route('halkontruksi') }}">Kontruksi</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</nav>

<div class="container">
    @php use Carbon\Carbon; @endphp

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pekerjaan</th>
                <th>Nilai Kontrak</th>
                <th>Tanggal Terkontrak</th>
                <th>Progres %</th>
                <th>Keterangan</th>
                <th>BA LKP</th>
                <th>BA PP</th>
                <th>BA ST</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kontraks as $index => $kontrak)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kontrak['pekerjaan'] ?? '-' }}</td>
                <td>
                    @isset($kontrak['nilai'])
                        Rp{{ number_format($kontrak['nilai'], 0, ',', '.') }}
                    @else
                        -
                    @endisset
                </td>
                <td>
                    @isset($kontrak['tanggal_kontrak'])
                        {{ Carbon::parse($kontrak['tanggal_kontrak'])->format('d-m-Y') }}
                    @else
                        -
                    @endisset
                </td>
                <td>{{ $kontrak['progres'] ?? '0' }}%</td>
                <td>{{ $kontrak['keterangan'] ?? '-' }}</td>
                <td>
                    @if (!empty($kontrak['bp_lkp']))
                        <a href="{{ asset('storage/' . $kontrak['bp_lkp']) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if (!empty($kontrak['bp_pp']))
                        <a href="{{ asset('storage/' . $kontrak['bp_pp']) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if (!empty($kontrak['bp_st']))
                        <a href="{{ asset('storage/' . $kontrak['bp_st']) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="btn-group">
        <a href="{{ route('halkontruksi') }}" class="btn-back">Back</a>
        <a href="{{ route('kontrak.create') }}" class="btn-edit">Edit</a>
    </div>
</div>

</body>
</html>
