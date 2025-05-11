<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Bidang</title>
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
       body {
    background: url('{{ asset('assets/bg.jpg') }}') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.navbar {
    background: #12092F;
    padding: 15px 30px;  /* Adjust padding for spacing */
    display: flex;
    justify-content: center;  /* Centers the navbar items horizontally */
    align-items: center;  /* Centers the items vertically */
    position: fixed;
    top: 0;
    left: 0;  /* Ensure the navbar starts from the left edge */
    width: 100%;  /* Full width of the screen */
    z-index: 10;
}

.navbar ul {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.navbar ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.container {
    padding-top: 70px;  /* Reduced space from navbar */
    display: flex;
    flex-direction: column;
    align-items: center;
}

.header-bar {
    width: 95%;
    max-width: 1200px;
    margin-bottom: 10px;  /* Reduced space between header and buttons */
    text-align: center;
}

h2 {
    color: white;
    font-size: 22px;
    font-weight: bold;
    text-shadow: 1px 1px 3px black;
    margin-bottom: 10px; /* Reduced space below the title */
}

.btn-downloads {
    margin-bottom: 10px;  /* Reduced space between buttons and table */
    display: flex;
    gap: 15px;
}

.btn-downloads form button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-downloads form:last-child button {
    background-color: #dc3545;
}

.btn-downloads form button:hover {
    opacity: 0.85;
}

table {
    background: white;
    border-collapse: collapse;
    width: 80%; /* Set a fixed percentage width to make it smaller than the screen */
    max-width: 800px; /* Max width ensures it doesn't grow too large */
    margin-bottom: 15px; /* Reduced space between table and next elements */
    overflow-x: auto; /* Allow horizontal scrolling if content exceeds table width */
    margin-left: auto; /* Center the table horizontally */
    margin-right: auto; /* Center the table horizontally */
}

table th, table td {
    border: 1px solid black;
    padding: 4px 6px; /* Reduced padding for smaller cells */
    text-align: center;
}

table th {
    background: #eee;
    font-size: 14px; /* Slightly smaller font size for the header */
}

table td {
    font-size: 13px; /* Slightly smaller font size for the cells */
}

/* Styling for the icon buttons */
.btn-icon {
    font-size: 16px;
    padding: 5px;
    cursor: pointer;
    border: none;
    background: none;
}

.btn-icon:hover {
    opacity: 0.7;
}

    </style>
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="#">👤 {{ Auth::user()->username }}</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ route('halrenev') }}">Renev</a></li>
            <li><a href="{{ route('reports.index') }}">Reports</a></li>
            <li><a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </nav>

    <div class="container">
        <div class="header-bar">
            <h2>Laporan Data Renev</h2>
        </div>

        <div class="btn-downloads">
            <form action="{{ route('reports.export.excel') }}" method="GET">
                <button type="submit">⬇️ Download Excel</button>
            </form>
            <form action="{{ route('reports.export.pdf') }}" method="GET">
                <button type="submit">🧾 Download PDF</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Unsur</th>
                    <th>Fungsi</th>
                    <th>No PRK</th>
                    <th>SKKO</th>
                    <th>Pekerjaan</th>
                    <th>Satuan</th>
                    <th>Volume</th>
                    <th>Total Material (Rp)</th>
                    <th>Total Jasa (Rp)</th>
                    <th>Jumlah Pagu (Rp)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($renevs as $renev)
                    <tr>
                        <td>{{ $renev->unsur->nama ?? '-' }}</td>
                        <td>{{ $renev->fungsi ? $renev->fungsi->nama : 'Tidak Ada Fungsi' }}</td>
                        <td>{{ $renev->no_prk }}</td>
                        <td>{{ $renev->no_skko }}</td>
                        <td>{{ $renev->pekerjaan }}</td>
                        <td>{{ $renev->satuan }}</td>
                        <td>{{ $renev->volume }}</td>
                        <td>{{ number_format($renev->total_material, 0, ',', '.') }}</td>
                        <td>{{ number_format($renev->total_jasa, 0, ',', '.') }}</td>
                        <td>{{ number_format($renev->jumlah_pagu, 0, ',', '.') }}</td>
                        <td>
                            <!-- Edit Button with Icon -->
                            <a href="{{ route('halrenev.reports.edit', $renev->id) }}" class="btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete Button with Icon -->
                            <form action="{{ route('halrenev.reports.destroy', $renev->id) }}" method="POST"
                                style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
