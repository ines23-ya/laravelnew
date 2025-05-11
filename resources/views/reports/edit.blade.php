<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Renev</title>
    <style>
        body {
            background: url('{{ asset('assets/bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

     .navbar {
    background: #12092F;
    padding: 15px 30px;  /* Adjust padding for spacing */
    display: flex;
    justify-content: center;  /* Centers the navbar items horizontally */
    align-items: center;  /* Centers the items vertically */
    position: fixed;
    top: 0;
    left: 0;  /* Ensure the navbar starts from the left edge */
    width: 100%;  /* Full width of the screen */
    z-index: 10;
}

.navbar ul {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.navbar ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}


        .container {
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h3 {
            color: white;
            text-shadow: 1px 1px 3px black;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 95%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ route('halrenev') }}">Renev</a></li>
            <li><a href="{{ route('reports.index') }}">Reports</a></li>
            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </nav>

    <div class="container">
        <h3>Edit Data Renev</h3>

        <form action="{{ route('halrenev.reports.update', $renev->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Form fields (unsur, fungsi, dll.) -->
            <div class="form-group">
                <label>Unsur</label>
                <select name="unsur_id" class="form-control" required>
                    @foreach($unsurs as $unsur)
                        <option value="{{ $unsur->id }}" {{ $renev->unsur_id == $unsur->id ? 'selected' : '' }}>{{ $unsur->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Fungsi</label>
                <select name="fungsi_id" class="form-control" required>
                    @foreach($fungsis as $fungsi)
                        <option value="{{ $fungsi->id }}" {{ $renev->fungsi_id == $fungsi->id ? 'selected' : '' }}>{{ $fungsi->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>No PRK</label>
                <input type="text" name="no_prk" value="{{ str_replace('PRK.3216.', '', $renev->no_prk) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>No SKKO</label>
                <input type="text" name="no_skko" value="{{ str_replace('SKKO.3216.', '', $renev->no_skko) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ $renev->pekerjaan }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" value="{{ $renev->satuan }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Volume</label>
                <input type="text" name="volume" value="{{ $renev->volume }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Total Material (Rp)</label>
                <input type="text" name="total_material" value="{{ $renev->total_material }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Total Jasa (Rp)</label>
                <input type="text" name="total_jasa" value="{{ $renev->total_jasa }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Jumlah Pagu (Rp)</label>
                <input type="text" name="jumlah_pagu" value="{{ $renev->jumlah_pagu }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</body>

</html>
