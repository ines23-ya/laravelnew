<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
@section('content')
    <h1>Halaman Tambah Unsur</h1>
    <!-- isi form -->
@endsection
