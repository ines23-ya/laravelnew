<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kontrak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
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
            color: black;
            margin-bottom: 10px; /* Reduced space at the bottom */
        }

        th, td {
            border: 1px solid #000;
            text-align: center;
            padding: 6px 10px; /* Reduced padding for a smaller table */
            font-size: 14px;
        }

        th {
            background-color: #f8f8f8;
        }

        .btn-group {
            margin-top: 20px;
            text-align: center;
        }

        .btn-group a {
            padding: 10px 20px;
            margin: 0 2px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .btn-back {
            background-color: #007bff;
        }

        .btn-edit {
            background-color: #2d6a4f;
        }

        .icon-btn {
    font-size: 18px;
    color: black;
    background-color: transparent;
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    display: block;
    margin: 0 auto; /* Ensure the icons are centered and aligned */
    width: 32px; /* Set the width to make sure both icons have the same size */
    height: 32px; /* Same for height */
    text-align: center; /* Center the icon inside the button */
}

.icon-btn-delete {
    font-size: 18px;
    color: black;
    background-color: transparent;
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    display: block;
    margin: 0 auto; /* Aligns the delete icon the same as the edit icon */
    width: 32px; /* Same size as the edit icon */
    height: 32px; /* Same height as the edit icon */
    text-align: center; /* Ensure icon is centered */
}


        h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: white;
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

    <!-- Judul -->
    <h2>Tabel Hasil Kontrak</h2>

    <!-- Tombol Download -->
    <div class="btn-group" style="margin-bottom: 20px;">
        <a href="{{ route('kontrak.exportExcel') }}" class="btn-edit" style="background-color: #0c9439;">Download Excel</a>
        <a href="{{ route('kontrak.exportPDF') }}" class="btn-edit" style="background-color: #f50820;">Download PDF</a>
    </div>

    <!-- Tabel Data -->
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
                <th>Action</th> <!-- Action Column -->
            </tr>
        </thead>
        <tbody>
            @foreach ($kontruksi as $index => $kontrak)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kontrak->pekerjaan ?? '-' }}</td>
                <td>
                    @isset($kontrak->pengadaan->nilai_kontrak)
                        Rp{{ number_format($kontrak->pengadaan->nilai_kontrak, 0, ',', '.') }}
                    @else
                        -
                    @endisset
                </td>
                <td>
                    @isset($kontrak->pengadaan->tanggal_kontrak)
                        {{ \Carbon\Carbon::parse($kontrak->pengadaan->tanggal_kontrak)->format('d-m-Y') }}
                    @else
                        -
                    @endisset
                </td>
                <td>{{ $kontrak->progres ?? '0' }}%</td>
                <td>{{ $kontrak->keterangan ?? '-' }}</td>
                <td>
                    @if (!empty($kontrak->bp_lkp))
                        <a href="{{ asset('storage/' . $kontrak->bp_lkp) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if (!empty($kontrak->bp_pp))
                        <a href="{{ asset('storage/' . $kontrak->bp_pp) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if (!empty($kontrak->bp_st))
                        <a href="{{ asset('storage/' . $kontrak->bp_st) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <!-- Edit Icon (Stacked vertically) -->
                    <a href="{{ route('kontruksi.edit', $kontrak->id) }}" class="icon-btn"><i class="fas fa-edit"></i></a>
                    
                    <!-- Delete Icon (Stacked vertically) -->
                    <form action="{{ route('kontruksi.destroy', $kontrak->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="icon-btn-delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>
