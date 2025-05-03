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
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
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
                    @forelse ($data_keuangan as $index => $item)


                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['no_prk'] ?? '-' }}</td>
                            <td>{{ $item['no_kontrak'] ?? '-' }}</td>
                            <td>{{ $item['pekerjaan'] ?? '-' }}</td>
                            <td>Rp {{ number_format($item['nilai'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item['jangka_waktu'] ?? '-' }} hari</td>
                            <td>{{ $item['progres'] ?? 0 }}%</td>
                            <td>
                                @if(!empty($item['bp_lkp']))
                                    <a href="{{ asset('storage/' . $item['bp_lkp']) }}" target="_blank" class="icon">📥</a>
                                @else ❌ @endif
                            </td>
                            <td>
                                @if(!empty($item['bp_st']))
                                    <a href="{{ asset('storage/' . $item['bp_st']) }}" target="_blank" class="icon">📥</a>
                                @else ❌ @endif
                            </td>
                            <td>
                                @if(!empty($item['bp_pp']))
                                    <a href="{{ asset('storage/' . $item['bp_pp']) }}" target="_blank" class="icon">📥</a>
                                @else ❌ @endif
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

                        <!-- Modal Input -->
                        <div class="modal fade" id="modalInput{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalLabel{{ $index }}">Input Pembayaran</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="no_kontrak" value="{{ $item['no_kontrak'] ?? '' }}">
                                  <div class="mb-3">
                                    <label>Upload BA Pembayaran (PDF)</label>
                                    <input type="file" name="ba_pembayaran" class="form-control" accept="application/pdf" required>
                                  </div>
                                  <div class="mb-3">
                                    <label>Jumlah Pembayaran (Rp)</label>
                                    <input type="number" name="jumlah_pembayaran" id="bayar{{ $index }}" class="form-control"
                                           oninput="hitungProgres({{ $index }}, {{ (int) ($item['nilai'] ?? 1) }})" required>
                                  </div>
                                  <div class="mb-3">
                                    <label>Progres Pembayaran (%)</label>
                                    <input type="number" name="progres" id="progres{{ $index }}" class="form-control" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" required>
                                  </div>
                                  <div class="mb-3">
                                    <label>Tanggal Upload</label>
                                    <input type="date" name="tanggal_upload" class="form-control" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    @empty
                        <tr><td colspan="13" class="text-center text-danger">Tidak ada data ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function hitungProgres(index, totalKontrak) {
        const bayar = parseFloat(document.getElementById('bayar' + index).value) || 0;
        const progres = document.getElementById('progres' + index);
        if (bayar > 0 && totalKontrak > 0) {
            let persen = (bayar / totalKontrak) * 100;
            if (persen > 100) persen = 100;
            progres.value = persen.toFixed(2);
        } else {
            progres.value = 0;
        }
    }
</script>

</body>
</html>
