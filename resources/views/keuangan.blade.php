<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            color: black;
            padding-top: 90px;
        }
        .navbar {
            background: #12092F;
            padding: 15px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
        }
        .navbar a {
            color: white;
            font-weight: bold;
            margin-right: 15px;
            text-decoration: none;
        }
        .container {
            padding: 20px;
        }
        .table-wrapper {
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 10px;
        }
        .icon {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="navbar d-flex justify-content-center align-items-center">
    <a href="#">👤 {{ Auth::user()->username }}</a>
    <a href="#">Dashboard</a>
    <a href="{{ route('keuangan') }}">Keuangan</a>
    <a href="{{ route('reportskeuangan') }}">Reports</a>

    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</div>

<div class="container">
    <div class="table-wrapper shadow">
        <h2 class="mb-4 text-center">Data Pembayaran - Bidang Keuangan</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>No PRK</th>
                        <th>No Kontrak</th>
                        <th>Pekerjaan</th>
                        <th>Nilai</th>
                        <th>Jangka Waktu</th>
                        <th>Progres</th>
                        <th>BP LKP</th>
                        <th>BP ST</th>
                        <th>BP PP</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Input</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($data_keuangan as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item['no_prk'] ?? '-' }}</td>
        <td>{{ $item['no_kontrak'] ?? '-' }}</td>
        <td>{{ $item['judul_kontrak'] ?? '-' }}</td>
        <td>Rp {{ number_format($item['nilai'], 0, ',', '.') }}</td>
        <td>{{ $item['jangka_waktu'] ?? '-' }} hari</td>
        <td>{{ $item['progres'] }}%</td>
        <td>
            @if(!empty($item['bp_lkp']))
                <a href="{{ asset('storage/' . $item['bp_lkp']) }}" target="_blank" class="icon">📥</a>
            @else
                ❌
            @endif
        </td>
        <td>
            @if(!empty($item['bp_st']))
                <a href="{{ asset('storage/' . $item['bp_st']) }}" target="_blank" class="icon">📥</a>
            @else
                ❌
            @endif
        </td>
        <td>
            @if(!empty($item['bp_pp']))
                <a href="{{ asset('storage/' . $item['bp_pp']) }}" target="_blank" class="icon">📥</a>
            @else
                ❌
            @endif
        </td>
        <td>{{ $item['keterangan'] ?? '-' }}</td>
        <td>
            @if(($item['progres'] ?? 0) >= 100)
                <span class="badge bg-success">Selesai</span>
            @else
                <span class="badge bg-warning text-dark">Diproses</span>
            @endif
        </td>
        <td>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalInput{{ $index }}">Input</button>
        </td>
    </tr>
@endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
