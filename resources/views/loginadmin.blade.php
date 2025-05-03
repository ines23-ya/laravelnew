<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Renev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background dengan gambar */
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Container login */
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
           
            background: white
            color: black;
        }

        /* Placeholder styling */
        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.7);
        }

        /* Tombol login */
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

        /* Hover button */
        .login-btn:hover {
            background-color: #138496;
        }

        
    </style>
</head>
<body>

    <div class="login-container">
        <h3 class="text-white">Login Admin</h3>
        <form action="{{ route('login.admin.post') }}" method="POST">
            @csrf
            <input type="hidden" name="bidang" value="Admin">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
        
    </div>

</body>
</html>
