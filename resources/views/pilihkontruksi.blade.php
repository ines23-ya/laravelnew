{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Halrenev - Monev Anggaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-nav .nav-link {
      color: white !important;
      font-weight: bold;
      margin: 0 10px;
    }

    .navbar {
      background-color: #1a1a2e !important;
    }

    body {
      margin: 0;
      padding: 0;
      background-image: url('{{ asset("assets/bg.jpg") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .form-wrapper {
      max-width: 500px;
      width: 100%;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .centered-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: start;
      padding-top: 50px;
      padding-bottom: 50px;
      box-sizing: border-box;
    }

    footer {
      color: rgb(20, 7, 66);
      text-align: center;
      font-size: 14px;
      padding: 20px 0;
      margin-bottom: 20px;
    }

    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#">👤 {{ Auth::user()->username }}</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('halrenev') }}">Renev</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Reports</a></li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container centered-container">
    <div class="form-wrapper">
      <h3 class="text-center text-dark mb-4">Monev Anggaran</h3>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('halrenev.store') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Unsur</label>
          <select class="form-select" name="unsur" required>
            <option value="">Pilih</option>
            <option value="Non Rutin">Non Rutin</option>
            <option value="Rutin - Sewa">Rutin - Sewa</option>
            <option value="Rutin Alih Daya">Rutin Alih Daya</option>
            <option value="Rutin Non Alih Daya">Rutin Non Alih Daya</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Fungsi</label>
          <select class="form-select" name="fungsi" required>
            <option value="">Pilih</option>
            <option value="K2LH">K2LH</option>
            <option value="Tata Usaha">Tata Usaha</option>
            <option value="Transmisi">Transmisi</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">No PRK</label>
          <div class="input-group">
            <span class="input-group-text">PRK.3216.</span>
            <input type="text" class="form-control" name="no_prk" placeholder="Lanjutan No PRK" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">SSKO</label>
          <div class="input-group">
            <span class="input-group-text">SKKO.3216.</span>
            <input type="text" class="form-control" name="no_skko" placeholder="Lanjutan No SKKO" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Pekerjaan</label>
          <input type="text" class="form-control" name="pekerjaan" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Satuan</label>
          <input type="text" class="form-control" name="satuan" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Volume</label>
          <input type="number" class="form-control" name="volume" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Total Material</label>
          <input type="number" class="form-control" name="total_material" id="total_material" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Total Jasa</label>
          <input type="number" class="form-control" name="total_jasa" id="total_jasa" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Jumlah Pagu</label>
          <input type="number" class="form-control" name="jumlah_pagu" id="jumlah_pagu" required readonly>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; 2025 Politeknik Negeri Padang. All rights reserved.
  </footer>

  <script>
    function updateJumlahPagu() {
      const material = parseFloat(document.getElementById('total_material').value) || 0;
      const jasa = parseFloat(document.getElementById('total_jasa').value) || 0;
      document.getElementById('jumlah_pagu').value = material + jasa;
    }

    document.getElementById('total_material').addEventListener('input', updateJumlahPagu);
    document.getElementById('total_jasa').addEventListener('input', updateJumlahPagu);
  </script>
</body>
</html> --}}
