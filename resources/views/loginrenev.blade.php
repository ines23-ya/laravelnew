<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Renev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background with image */
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Login container */
        .login-container {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 350px;
        }

        /* Input form */
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 50px;
            background: white;
            color: black;
        }

        /* Placeholder styling */
        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.7);
        }

        /* Login button */
        .login-btn {
            width: 50%;
            background-color: #17a2b8;
            border: none;
            padding: 12px;
            border-radius: 50px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* Hover effect for login button */
        .login-btn:hover {
            background-color: #138496;
        }

        /* Error message styling */
        .error-message {
            color: #ff3333;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h3 class="text-white">Login Renev</h3>

        <!-- Display error message if login fails -->
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <!-- Display validation errors from the backend -->
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.renev.post') }}" method="POST">
            @csrf
            <input type="hidden" name="bidang" value="Renev">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</body>

</html>
