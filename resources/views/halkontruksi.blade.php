<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Konstruksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
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

        .container {
            flex: 1;
            padding-top: 120px;
            padding-bottom: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            text-shadow: 1px 1px 3px black;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input[type="text"] {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
        }

        table {
            background: white;
            border-collapse: collapse;
            width: 300px;
            color: black;
        }

        table th, table td {
            border: 1px solid black;
            padding: 8px 10px;
            text-align: center;
        }

        table th {
            background: #eee;
        }

        .btn-show {
            margin-top: 15px;
            background: orange;
            padding: 8px 15px;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-show:hover {
            background: darkorange;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        footer {
            color: rgb(20, 7, 66);
            text-align: center;
            font-size: 14px;
            padding: 20px 0;
            margin-top: auto;
            width: 100%;
        }
    </style>
</head>
<body>

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
    <h2>Halaman Konstruksi</h2>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari No Kontrak..." onkeyup="searchTable()">
    </div>

    <table id="kontrakTable">
        <thead>
            <tr>
                <th>No</th>
                <th>No Kontrak</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data_pbj as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['no_kontrak'] ?? '-' }}</td>
                    <td>
                        <a href="{{ url('/kontruksi/pilih') . '?no_kontrak=' . urlencode($item['no_kontrak']) }}" class="btn-edit">Pilih</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada data kontrak.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <button class="btn-show">Show Tables >></button>
</div>

<!-- Footer -->
<footer>
    &copy; 2025 Politeknik Negeri Padang. All rights reserved.
</footer>

<script>
    function searchTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("kontrakTable");
        const trs = table.getElementsByTagName("tr");

        for (let i = 1; i < trs.length; i++) {
            const td = trs[i].getElementsByTagName("td")[1];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                trs[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }
</script>

</body>
</html>
