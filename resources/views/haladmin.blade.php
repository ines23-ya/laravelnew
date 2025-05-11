<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: url('{{ asset("assets/bg.jpg") }}') no-repeat center center;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 56px);
            padding: 20px;
        }

        .account-btn {
            width: 100%;
            padding: 10px;
            border-radius: 20px;
            border: 2px solid black;
            background: white;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .modal-content {
            padding: 20px;
        }

        .navbar .nav-link {
            color: white !important;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link fw-bold" href="#">👤 {{ Auth::user()->username }}</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Admin</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Reports</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Konten -->
<div class="content-wrapper">
    <div class="content-box text-center">
        <h2 class="fw-bold text-white text-center">Daftar Account</h2>
        <div class="account-list mt-3">
            @foreach ($users as $user)
                <button class="account-btn" onclick="showAccountDetail({{ $user->id }})">{{ $user->username }}</button>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div id="accountModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> <span id="accountName"></span></p>
                <p><strong>Email:</strong> <span id="accountEmail"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="openEditModal()">Edit</button>
                <button class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editAccountModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAccountForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editUserId">

                <div class="mb-3">
                    <label for="editUsername" class="form-label">Username</label>
                    <input type="text" id="editUsername" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="editNik" class="form-label">NIK Pegawai</label>
                    <input type="text" id="editNik" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="editBidang" class="form-label">Bidang</label>
                    <select id="editBidang" class="form-select" required>
                        <option value="">Pilih Bidang</option>
                        <option value="Renev">Renev</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="Pengadaan">Pengadaan</option>
                        <option value="Kontruksi">Kontruksi</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" id="editEmail" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="editNoHp" class="form-label">No HP</label>
                    <input type="text" id="editNoHp" class="form-control" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AJAX -->
<script>
    let selectedUserId = null;

    function showAccountDetail(id) {
        $.get('/admin/account/' + id, function(data) {
            selectedUserId = data.id;
            $('#accountName').text(data.username);
            $('#accountEmail').text(data.email);
            $('#accountModal').modal('show');
        });
    }

    function openEditModal() {
        $.get('/admin/account/' + selectedUserId, function(data) {
            $('#editUserId').val(data.id);
            $('#editUsername').val(data.username);
            $('#editNik').val(data.nik);
            $('#editBidang').val(data.bidang);
            $('#editEmail').val(data.email);
            $('#editNoHp').val(data.no_hp);

            $('#accountModal').modal('hide');
            $('#editAccountModal').modal('show');
        });
    }

    $('#editAccountForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editUserId').val();
        const updatedData = {
            username: $('#editUsername').val(),
            nik: $('#editNik').val(),
            bidang: $('#editBidang').val(),
            email: $('#editEmail').val(),
            no_hp: $('#editNoHp').val()
        };

        $.ajax({
            url: '/admin/account/' + id,
            method: 'PUT',
            data: updatedData,
            success: function() {
                alert('Akun berhasil diperbarui');
                $('#editAccountModal').modal('hide');
                showAccountDetail(id);
            },
            error: function() {
                alert('Gagal memperbarui akun');
            }
        });
    });

    function confirmDelete() {
        if (confirm('Apakah Anda yakin mau menghapus akun ini?')) {
            $.ajax({
                url: '/admin/account/' + selectedUserId,
                method: 'DELETE',
                success: function() {
                    alert('Akun berhasil dihapus');
                    $('#accountModal').modal('hide');
                    window.location.href = '/admin'; // redirect ke halaman admin
                },
                error: function() {
                    alert('Gagal menghapus akun');
                }
            });
        }
    }
</script>

</body>
</html>
