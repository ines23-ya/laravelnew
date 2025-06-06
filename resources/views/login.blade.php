<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> <!-- Font Awesome -->

    <style>
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 350px;
            color: white;
        }

        .form-control {
            margin-bottom: 10px;
            border-radius: 50px;
            padding-right: 40px; /* Space for the eye icon */
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: gray;
        }

        .login-btn {
            width: 50%;
            background-color: #17a2b8;
            border: none;
            padding: 10px;
            border-radius: 50px;
            color: white;
        }

        .signup-link,
        .forgot-password {
            display: block;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Error message styling */
      .error-message {
    color: #ff3333; /* Red color for error */
    font-size: 16px; /* Increased font size */
    font-weight: bold; /* Make the text bold */
    margin-bottom: 15px;
}

    </style>
</head>

<body>

    <div class="login-container">
        <h3>Login</h3>

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

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="username" class="form-control" placeholder="Username" required>

            <div class="password-container">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i> <!-- Eye icon -->
            </div>

            <button type="submit" class="login-btn">Login</button>

            <!-- Link for password recovery -->
            <a href="{{ route('password.request') }}" class="forgot-password">Lupa Kata Sandi?</a>

            <!-- Link to the register page -->
            <a href="{{ route('register') }}" class="signup-link">Sign up</a>
        </form>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById("togglePassword").addEventListener("click", function () {
            let passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.remove("fa-eye");
                this.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                this.classList.remove("fa-eye-slash");
                this.classList.add("fa-eye");
            }
        });
    </script>

</body>

</html>
