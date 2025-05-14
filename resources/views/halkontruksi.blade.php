<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Konstruksi</title>
    <style>
       <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
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
            padding-top: 70px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 40px;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
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
            width: 100%;
            max-width: 400px;
            color: black;
             margin-bottom: 10px;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .btn-edit {
            background-color: #2d6a4f;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
        }

        .btn-edit:hover {
            background-color: #1b4332;
        }

        .btn-show {
            margin-top: 20px;
            background-color: #2d6a4f;
            padding: 10px 20px;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 6px;
        }

        .btn-show:hover {
            background-color: #1b4332;
        }

        footer {
            color: rgb(20, 7, 66);
            text-align: center;
            font-size: 14px;
            padding: 20px 0;
            margin-top: auto;
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .container {
                padding-top: 60px;
            }

            table {
                width: 100%;
            }

            .navbar ul {
                flex-direction: column;
            }

            .search-box input[type="text"] {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <ul>
        <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
        <li><a href="#">Dashboard</a></li>
        <li><a href="{{ route('halkontruksi') }}">Kontruksi</a></li>
       <li><a href="{{ route('hasilkontrak') }}">Reports</a></li>
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
                <th>Input Data Kontruksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengadaan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->no_kontrak }}</td>
                    <td>
                        <!-- Tombol untuk mengarahkan ke halaman input kontruksi -->
                        <a href="{{ route('halkontruksi.inputkontruksi', ['no_kontrak' => $item->no_kontrak]) }}" class="btn-edit">Input Data Kontruksi</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada data no kontrak.</td>
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
