<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashscreen</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: radial-gradient(circle, #ffffff 0%, #d2f4f4 35%, #AFDDFF 100%);

        }
        .flashscreen {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            animation: fadeIn 1.5s ease-in;
            box-sizing: border-box;
            text-align: center;
            color: #ffffff;
        }

        .welcome-text {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0cc0df;
        }

        .logo {
            width: 350px;
            max-width: 80vw;
            background: transparent;
        }

        .description-text {
            margin-top: 20px;
            font-size: 1.2rem;
            color: #0cc0df;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "/login";
        }, 5000);
    </script>
</head>
<body>
    <div class="flashscreen">
        <div class="welcome-text">Selamat datang di website monev</div>
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="logo">
        <div class="description-text">
            Monitoring dan Evaluasi Anggaran Operasi PLN (Persero) UPT Banda Aceh
        </div>
    </div>
</body>
</html>
