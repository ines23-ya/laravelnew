<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Berhasil Dibuat</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        /* Background */
        body {
            font-family: Arial, sans-serif;
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Kotak form */
        .success-container {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        /* Pesan sukses */
        .success-message {
            color: #28a745;
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* Tombol login */
        .login-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="success-container">
    <h2 class="success-message">
        {{ session('success') ?? 'Akun Anda Berhasil Dibuat!' }}
    </h2>
    <a href="{{ route('login') }}" class="login-btn">Login</a>
</div>

</body>
</html>
