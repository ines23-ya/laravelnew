<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Pengadaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('{{ asset('assets/bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
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

        .header-title {
            text-align: center;
            width: 100%;
            margin-bottom: 10px;
        }

        h2 {
            color: white;
            font-size: 22px;
            font-weight: bold;
            text-shadow: 1px 1px 3px black;
        }

        .form-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            width: 50%; /* Lebar form dikurangi 50% */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Menghilangkan tombol naik-turun pada input type number */
        input[type="number"] {
            -moz-appearance: textfield;  /* Firefox */
            appearance: textfield;       /* Chrome, Safari */
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto; /* Tombol di tengah */
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link-wrapper {
            width: 95%;
            max-width: 1200px;
            margin-bottom: 10px;
            text-align: left;
        }

        .back-link {
            font-size: 16px;
            font-weight: bold;
            color: #091057;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
            <li><a href="{{ route('pengadaan') }}">Dashboard</a></li>
            <li><a href="{{ route('pengadaan') }}">Pengadaan</a></li>
            <li><a href="{{ route('pengadaan.reports') }}">Reports</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="header-title">
            <h2>Edit Data Pengadaan</h2>
        </div>

        <div class="back-link-wrapper">
            <a href="{{ route('pengadaan.reports') }}" class="back-link">Kembali ke Halaman Report Pengadaan</a>
        </div>

        <div class="form-container">
            <form action="{{ route('pengadaan.update', $pengadaan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="no_kontrak">No Kontrak</label>
                    <input type="text" id="no_kontrak" name="no_kontrak" value="{{ old('no_kontrak', $pengadaan->no_kontrak) }}" required>
                </div>

                <div class="form-group">
                    <label for="judul_kontrak">Judul Kontrak</label>
                    <input type="text" id="judul_kontrak" name="judul_kontrak" value="{{ old('judul_kontrak', $pengadaan->judul_kontrak) }}" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_kontrak">Tanggal Kontrak</label>
                    <input type="date" id="tanggal_kontrak" name="tanggal_kontrak" value="{{ old('tanggal_kontrak', $pengadaan->tanggal_kontrak) }}" required>
                </div>

                <div class="form-group">
                    <label for="jangka_mulai">Jangka Mulai</label>
                    <input type="date" id="jangka_mulai" name="jangka_mulai" value="{{ old('jangka_mulai', $pengadaan->jangka_mulai) }}" required>
                </div>

                <div class="form-group">
                    <label for="jangka_akhir">Jangka Akhir</label>
                    <input type="date" id="jangka_akhir" name="jangka_akhir" value="{{ old('jangka_akhir', $pengadaan->jangka_akhir) }}" required>
                </div>

                <div class="form-group">
                    <label for="vendor_pelaksana">Vendor Pelaksana</label>
                    <input type="text" id="vendor_pelaksana" name="vendor_pelaksana" value="{{ old('vendor_pelaksana', $pengadaan->vendor_pelaksana) }}" required>
                </div>

                <div class="form-group">
                    <label for="nilai_kontrak">Nilai Kontrak</label>
                    <input type="number" id="nilai_kontrak" name="nilai_kontrak" value="{{ old('nilai_kontrak', $pengadaan->nilai_kontrak) }}" required>
                </div>

                <div class="form-group">
                    <label for="dokumen">Dokumen</label>
                    <input type="file" id="dokumen" name="dokumen" accept="application/pdf">
                    @if ($pengadaan->dokumen)
                        <p>Dokumen yang sudah ada: <a href="{{ route('pbj.download', basename($pengadaan->dokumen)) }}" target="_blank">Download</a></p>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit">Update Pengadaan</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
