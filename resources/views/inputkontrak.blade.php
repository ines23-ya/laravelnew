<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Pekerjaan dan Kontrak</title>
    <style>
        /* Your existing styles */
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
            padding-top: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-box {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 420px; /* Lebar dikurangi */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .btn-submit {
            background-color: #2d6a4f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            display: block;
            margin: 20px auto 0 auto; /* ini yang bikin tombol di tengah */
        }
        .btn-submit:hover {
            background-color: #1b4332;
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
    <div class="form-box">
        <h2>Input Data Pekerjaan dan Kontrak</h2>
        <form action="{{ route('kontruksi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="nomor_kontrak" value="{{ $no_kontrak }}">

            <div class="form-group">
                <label for="pekerjaan">Nama Pekerjaan</label>
                <input type="text" name="pekerjaan" required>
            </div>

            <div class="form-group">
                <label for="progres">Progres (%)</label>
                <input type="number" name="progres" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="bp_lkp">Upload BA LKP (PDF)</label>
                <input type="file" name="bp_lkp" accept="application/pdf" required>
            </div>

            <div class="form-group">
                <label for="bp_st">Upload BA ST (PDF)</label>
                <input type="file" name="bp_st" accept="application/pdf" required>
            </div>

            <div class="form-group">
                <label for="bp_pp">Upload BA PP (PDF)</label>
                <input type="file" name="bp_pp" accept="application/pdf" required>
            </div>

            <button type="submit" class="btn-submit">Add</button>
        </form>
       
    </div>
</div>

</body>
</html>
