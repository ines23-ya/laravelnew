@extends('layout.pengadaan.index')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .btn-pilih {
        background-color: #007bff; /* Warna Biru */
        border-color: #007bff; /* Warna Border Biru */
    }

    .btn-pilih:hover {
        background-color: #0056b3; /* Warna Biru Tua saat Hover */
        border-color: #004085; /* Warna Border Biru Tua saat Hover */
    }

    .action-btn {
        text-align: center; /* Memposisikan tombol di tengah */
    }
</style>

@section('content')
    @include('layout.sidebar')

    <div class="container mt-4">
        <h2 class="mb-4">Data Pengadaan</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Unsur</th>
                    <th>Fungsi</th>
                    <th>No PRK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengadaan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->unsur->nama ?? '-' }}</td>
                        <td>{{ $item->fungsi->nama ?? '-' }}</td>
                        <td>{{ $item->no_prk ?? '-' }}</td>
                        <td class="action-btn">
                            @php
                                $unsurId = $item->unsur->id ?? null;
                                $fungsiId = $item->fungsi->id ?? null;
                            @endphp

                            @if (session()->has('selected_no_prk') && session('selected_no_prk') == $item->no_prk)
                                <button class="btn btn-secondary btn-sm" disabled data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Sudah Dipilih">
                                    <span class="d-none d-sm-inline">Sudah Dipilih</span>
                                </button>
                            @elseif ($unsurId && $fungsiId)
                                <a href="{{ route('pbj.create', ['no_prk' => $item->no_prk, 'unsur' => $unsurId, 'fungsi' => $fungsiId]) }}"
                                    class="btn btn-pilih btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Pilih Pengadaan">
                                    <span class="d-none d-sm-inline">Pilih</span>
                                </a>
                            @else
                                <button class="btn btn-warning btn-sm" disabled data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Unsur atau Fungsi belum lengkap">
                                    <span class="d-none d-sm-inline">Data Tidak Lengkap</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
