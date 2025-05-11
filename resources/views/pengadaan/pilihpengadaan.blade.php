@extends('layout.pengadaan.pilih')

@section('content')
    @include('layout.sidebar')

    <div class="form-container" style="margin-top: 100px;">
        <h2>Input PBJ</h2>
        <form action="{{ route('pbj.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Hidden input for passing ID (jika kamu nanti butuh ID dari renev) -->
            <input type="hidden" name="pengadaan_id" value="{{ $noPrkData->id ?? '' }}">

            <!-- Unsur, Fungsi, and No PRK yang tidak bisa diubah -->
            <table class="table table-bordered">
                <div class="form-group">
                    <label for="unsur">Unsur:</label>
                    <input type="text" id="unsur" name="unsur" value="{{ $noPrkData->unsur->nama ?? 'Data tidak ditemukan' }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="fungsi">Fungsi:</label>
                    <input type="text" id="fungsi" name="fungsi" value="{{ $noPrkData->fungsi->nama ?? 'Data tidak ditemukan' }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="no_prk">No PRK:</label>
                    <input type="text" id="no_prk" name="no_prk" value="{{ $noPrkData->no_prk ?? 'Data tidak ditemukan' }}" class="form-control" readonly>
                </div>

            <!-- Form lainnya tetap sama -->
            <div class="form-group">
                <label for="no_kontrak">No Kontrak</label>
                <input type="text" name="no_kontrak" id="no_kontrak" class="form-control" placeholder="No Kontrak" required value="{{ old('no_kontrak') }}">
                @error('no_kontrak') 
                    <div class="text-danger">{{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="judul_kontrak">Judul Kontrak</label>
                <input type="text" name="judul_kontrak" id="judul_kontrak" class="form-control" placeholder="Judul Kontrak" required value="{{ old('judul_kontrak') }}">
                @error('judul_kontrak') 
                    <div class="text-danger">{{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_kontrak">Tanggal Kontrak</label>
                <input type="date" name="tanggal_kontrak" id="tanggal_kontrak" class="form-control" required value="{{ old('tanggal_kontrak') }}">
                @error('tanggal_kontrak') 
                    <div class="text-danger">{{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="jangka_mulai">Jangka Waktu</label>
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; font-weight: bold;">Mulai</label>
                        <input type="date" name="jangka_mulai" id="jangka_mulai" class="form-control" required onchange="hitungHari()">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 13px; font-weight: bold;">Akhir</label>
                        <input type="date" name="jangka_akhir" id="jangka_akhir" class="form-control" required onchange="hitungHari()">
                    </div>
                </div>
                <small id="durasi_hari" style="display: block; margin-top: 5px; font-weight: bold;"></small>
            </div>

            <div class="form-group">
                <label for="vendor_pelaksana">Vendor Pelaksana</label>
                <input type="text" name="vendor_pelaksana" id="vendor_pelaksana" class="form-control" placeholder="Vendor Pelaksana" required value="{{ old('vendor_pelaksana') }}">
                @error('vendor_pelaksana') 
                    <div class="text-danger">{{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="nilai_kontrak">Nilai Kontrak</label>
                <input type="number" name="nilai_kontrak" id="nilai_kontrak" class="form-control" placeholder="Nilai Kontrak" required autocomplete="off" value="{{ old('nilai_kontrak') }}">
                @error('nilai_kontrak') 
                    <div class="text-danger">{{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="dokumen">Dokumen (PDF)</label>
                <input type="file" name="dokumen" id="dokumen" class="form-control" accept="application/pdf" required>
                @error('dokumen') 
                    <div class="text-danger">{{ $message }}</div> 
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        function hitungHari() {
            const mulai = document.getElementById("jangka_mulai").value;
            const akhir = document.getElementById("jangka_akhir").value;
            const output = document.getElementById("durasi_hari");

            if (mulai && akhir) {
                const start = new Date(mulai);
                const end = new Date(akhir);
                const selisih = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                output.innerText = selisih > 0 ? `Durasi: ${selisih} hari` : '';
            } else {
                output.innerText = '';
            }
        }
    </script>
@endsection
