<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .forgot-password-container {
            background: white;
            padding: 25px;
            margin-bottom: 20px; 
            text-align: center;
            width: 350px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            margin-bottom: 30px;
            border-radius: 50px;
            text-align: center;
            margin-top: 30px; 
        }
        .btn-send {
            width: 100%;
            background-color: #17a2b8;
            border: none;
            padding: 10px;
            border-radius: 50px;
            color: white;
        }
        .login-link {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>

    <div class="forgot-password-container">
        <h3>Lupa Kata Sandi</h3>
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
            <button type="submit" class="btn-send">Send</button>
            <a href="{{ route('login') }}" class="login-link">Login</a>
        </form>
    </div>

</body>
</html>
