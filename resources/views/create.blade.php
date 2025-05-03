<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="{{ asset('css/stylea.css') }}" rel="stylesheet">
    <style>
        .password-requirements {
            list-style: none;
            padding: 0;
            font-size: 14px;
        }

        .password-requirements .invalid {
            color: rgb(255, 255, 255);
        }

        .password-requirements .valid {
            color: green;
        }
    </style>
</head>
<body>
<div class="create">
    <h1>Create Account</h1>

    <!-- Menampilkan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username" required value="{{ old('username') }}">
        <input type="text" name="nik" placeholder="NIK Pegawai" required value="{{ old('nik') }}">

        <select name="bidang" required>
            <option value="">Pilih Bidang</option>
            <option value="Renev" {{ old('bidang') == 'Renev' ? 'selected' : '' }}>Renev</option>
            <option value="Keuangan" {{ old('bidang') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
            <option value="Pengadaan" {{ old('bidang') == 'Pengadaan' ? 'selected' : '' }}>Pengadaan</option>
            <option value="Kontruksi" {{ old('bidang') == 'Kontruksi' ? 'selected' : '' }}>Kontruksi</option>
            <option value="Admin" {{ old('bidang') == 'Admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
        <input type="text" name="no_hp" placeholder="No HP" required value="{{ old('no_hp') }}">

        <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span onclick="togglePassword('password')" class="eye-icon">&#128065;</span>
        </div>

        <div class="password-container">
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
            <span onclick="togglePassword('password_confirmation')" class="eye-icon">&#128065;</span>
        </div>

        <!-- Notifikasi syarat password -->
        <ul class="password-requirements">
            <li id="length" class="invalid">Password Minimal 8 karakter ❌</li>
            <li id="complex" class="invalid">Gabungan Huruf, Angka, Karakter ❌</li>

        </ul>

        <button type="submit" class="create-btn">Create</button>
    </form>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }

    document.getElementById('password').addEventListener('input', function () {
        const password = this.value;

        // Cek panjang
        document.getElementById('length').className = password.length >= 8 ? 'valid' : 'invalid';
        document.getElementById('length').innerHTML = password.length >= 8
            ? 'Password Minimal 8 karakter ✅'
            : 'Password Minimal 8 karakter ❌';

        // Cek kompleksitas: huruf & angka & karakter
        const complexPattern = /(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z0-9])/;
        document.getElementById('complex').className = complexPattern.test(password) ? 'valid' : 'invalid';
        document.getElementById('complex').innerHTML = complexPattern.test(password)
            ? 'Gabungan Huruf, Angka, Karakter ✅'
            : 'Gabungan Huruf, Angka, Karakter ❌';
    });
</script>

</body>
</html>
