<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Sarpras Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #2163a5;
        }
        .sidebar a {
            color: #fff;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #2b5885;
        }
        .content {
            padding: 20px;
        }
        img {
            width: 100px;
            height: 100px;
            margin-left: 40px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png">
        <a href="{{ route('dashboard') }}">Beranda</a>
        <a href="{{ route('peminjaman.index') }}">Data Peminjaman</a>
        <a href="#">Data Pengembalian</a>
        <a href="{{ route('item.index') }}">Item</a>
        <a href="{{ route('kategori.index') }}">Kategori</a>
        <a href="{{ route('datauser') }}">Pengguna</a>
    </div>

    <!-- Main content -->
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Halaman Akun Pengguna</span>
                <div class="d-flex">
                    <span class="me-3">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="content">
            <h4>Halaman Akun Pengguna</h4>
            <a href="{{ route('register') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>
            <table id="usersTable" class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Admin</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->admin->name ?? '-' }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada akun pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        // Inisialisasi DataTables pada tabel dengan ID 'usersTable'
        $('#usersTable').DataTable();
    });
</script>

</body>
</html>

