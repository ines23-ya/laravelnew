<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input PBJ</title>
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            display: block;
        }

        .navbar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .form-container {
            margin-top: 130px;
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #000;
            border-radius: 5px;
        }

        .form-group input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #000;
            border-radius: 5px;
            appearance: textfield;
            -moz-appearance: textfield;
        }

        .form-group input[type="number"]::-webkit-inner-spin-button,
        .form-group input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .form-group label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .btn-submit {
            background-color: green;
            color: white;
            padding: 10px 30px;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: darkgreen;
        }

        .back-arrow {
            position: absolute;
            left: 10px;
            top: 20px;
            font-size: 30px;
            text-decoration: none;
            color: white;
        }
    </style>
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
</head>
<body>

<a href="{{ route('pengadaan') }}" class="back-arrow">←</a>

<nav class="navbar">
    <ul>
        <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
        <li><a href="#">Dashboard</a></li>
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

<div class="form-container">
    <h2>Input PBJ</h2>
    <form action="{{ route('pbj.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" name="no_kontrak" placeholder="No Kontrak" required>
        </div>
        <div class="form-group">
            <input type="text" name="judul_kontrak" placeholder="Judul Kontrak" required>
        </div>
        <div class="form-group">
            <input type="date" name="tanggal_kontrak" placeholder="Tanggal Terkontrak" required>
        </div>
        <div class="form-group">
            <label for="jangka_mulai">Jangka Waktu</label>
            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label style="font-size: 13px; font-weight: bold;">Mulai</label>
                    <input type="date" name="jangka_mulai" id="jangka_mulai" required onchange="hitungHari()">
                </div>
                <div style="flex: 1;">
                    <label style="font-size: 13px; font-weight: bold;">Akhir</label>
                    <input type="date" name="jangka_akhir" id="jangka_akhir" required onchange="hitungHari()">
                </div>
            </div>
            <small id="durasi_hari" style="display: block; margin-top: 5px; font-weight: bold;"></small>
        </div>
        <div class="form-group">
            <input type="text" name="vendor_pelaksana" placeholder="Vendor Pelaksana" required>
        </div>
        <div class="form-group">
            <input type="number" name="nilai_kontrak" placeholder="Nilai Kontrak" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>Dokumen (PDF)</label>
            <input type="file" name="dokumen" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn-submit">Add</button>
    </form>
</div>

</body>
</html>
