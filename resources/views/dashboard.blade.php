<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            let confirmation = confirm("Apakah Anda yakin ingin keluar?");
            if (confirmation) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
</head>
<body>

<nav class="navbar">
    <ul>
        @auth
            <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Bidang <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="{{ route('login.renev')}}">Renev</a>
                    <a href="{{ route('login.keuangan') }}">Keuangan</a>
                    <a href="{{ route('login.pengadaan') }}">Pengadaan</a>
                    <a href="{{ route('login.kontruksi') }}">Kontruksi</a>
                    <li><a href="{{ route('login.admin') }}">Admin</a></li>
                </div>
            </li>
            <li><a href="#">Reports</a></li>
            <li>
                <a href="#" onclick="confirmLogout(event)">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @else
            <li><a href="#">Guest</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        @endauth
    </ul>
</nav>

<div class="container">
    <h2>Monitoring dan Evaluasi Anggaran Operasi</h2>

    @php
        use Carbon\Carbon;
        $gabunganData = [];

        $data_kontrak = session('data_kontrak', []);
        $keuanganProgres = session('form_data')['progres_pembayaran'] ?? 0;

        foreach (session('data_pbj', []) as $item) {
            $no_kontrak = trim(strtolower($item['no_kontrak'] ?? ''));

            $progresPekerja = 0;
            foreach ($data_kontrak as $kontrak) {
                if (isset($kontrak['no_kontrak']) && trim(strtolower($kontrak['no_kontrak'])) === $no_kontrak) {
                    $progresPekerja = $kontrak['progres'] ?? 0;
                    break;
                }
            }

            $gabunganData[] = [
                'judul' => $item['judul_kontrak'] ?? '-',
                'nilai' => $item['nilai_kontrak'] ?? 0,
                'tanggal_kontrak' => $item['tanggal_kontrak'] ?? '-',
                'progres' => $progresPekerja,
                'progres_pembayaran' => $keuanganProgres,
                'id' => uniqid('pbj_')
            ];
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th>Judul Kontrak</th>
                <th>Tanggal Terkontrak</th>
                <th>Nilai Kontrak</th>
                <th>Progres Pekerjaan</th>
                <th>Progres Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gabunganData as $data)
                <tr>
                    <td>{{ $data['judul'] }}</td>
                    <td>
                        @if ($data['tanggal_kontrak'] !== '-')
                            {{ \Carbon\Carbon::parse($data['tanggal_kontrak'])->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>Rp{{ number_format($data['nilai'], 0, ',', '.') }}</td>
                    <td><canvas id="bar-{{ $data['id'] }}" width="100" height="40"></canvas></td>
                    <td><canvas id="pie-{{ $data['id'] }}" width="100" height="40"></canvas></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    @foreach ($gabunganData as $data)
        new Chart(document.getElementById("bar-{{ $data['id'] }}"), {
            type: 'bar',
            data: {
                labels: ["Pekerjaan"],
                datasets: [{
                    backgroundColor: "#3e95cd",
                    data: [{{ $data['progres'] }}]
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, max: 100 } },
                plugins: { legend: { display: false } }
            }
        });

        new Chart(document.getElementById("pie-{{ $data['id'] }}"), {
            type: 'doughnut',
            data: {
                labels: ["Selesai", "Sisa"],
                datasets: [{
                    backgroundColor: ["#28a745", "#dc3545"],
                    data: [{{ $data['progres_pembayaran'] }}, {{ 100 - $data['progres_pembayaran'] }}]
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    @endforeach
</script>

</body>
</html>
