<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kontruksi</title>
    <style>
        body {
            background: url('{{ asset('assets/bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
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

        h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: white;
            text-align: center;
        }

        form {
            background: rgba(255, 255, 255, 0.8); /* Slight white background to contrast with the image */
            padding: 12px;
            border-radius: 8px;
            width: 40%; /* Reduced the width of the form to 40% */
            margin: 100px auto; /* Center the form */
        }

        label {
            font-size: 12px; /* Smaller font size for labels */
            font-weight: bold;
            color: #333;
            display: block;
            margin: 8px 0 5px;
        }

        input[type="text"], input[type="number"], textarea, input[type="file"] {
            width: 100%;
            padding: 5px; /* Smaller padding */
            margin: 5px 0 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            padding: 8px 16px; /* Adjusted padding for button */
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #1e4d37;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Hide number input spinner */
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
            -webkit-appearance: none;  /* Chrome/Safari */
            appearance: none; /* Standard */
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
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
        <h2>Edit Kontruksi</h2>

        <!-- Form to edit kontruksi -->
        <form action="{{ route('kontruksi.update', $kontruksi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Specify method is PUT for updating -->

            <div>
                <label for="pekerjaan">Pekerjaan:</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="{{ $kontruksi->pekerjaan }}" required>
            </div>

            <div>
                <label for="nomor_kontrak">No Kontrak:</label>
                <input type="text" id="nomor_kontrak" name="nomor_kontrak" value="{{ $kontruksi->no_kontrak }}" required>
            </div>

            <div>
                <label for="progres">Progres (%):</label>
                <input type="number" id="progres" name="progres" value="{{ $kontruksi->progres }}" min="0" max="100" required>
            </div>

            <div>
                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan">{{ $kontruksi->keterangan }}</textarea>
            </div>

            <div>
                <label for="bp_lkp">BA LKP:</label>
                <input type="file" id="bp_lkp" name="bp_lkp">
                @if ($kontruksi->bp_lkp)
                    <a href="{{ asset('storage/' . $kontruksi->bp_lkp) }}" target="_blank">Lihat</a>
                @endif
            </div>

            <div>
                <label for="bp_pp">BA PP:</label>
                <input type="file" id="bp_pp" name="bp_pp">
                @if ($kontruksi->bp_pp)
                    <a href="{{ asset('storage/' . $kontruksi->bp_pp) }}" target="_blank">Lihat</a>
                @endif
            </div>

            <div>
                <label for="bp_st">BA ST:</label>
                <input type="file" id="bp_st" name="bp_st">
                @if ($kontruksi->bp_st)
                    <a href="{{ asset('storage/' . $kontruksi->bp_st) }}" target="_blank">Lihat</a>
                @endif
            </div>

            <button type="submit">Update</button>
        </form>
    </div>

</body>
</html>
