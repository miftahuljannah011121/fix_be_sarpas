<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SISFO SARPRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .btn-action {
            font-size: 0.875rem;
            padding: 4px 10px;
            margin-right: 5px;
        }

        .btn-hapus {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-hapus:hover {
            background-color: #bb2d3b;
        }
    </style>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar a {
            color: #ffffff;
            padding: 10px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
        }
    </style>


</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="text-white text-center py-3">SISFO SARPRAS</h4>
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('kategori.index') }}"
                    class="{{ request()->is('kategori*') ? 'active' : '' }}">Kategori Barang</a>
                <a href="{{ route('barang.index') }}" class="{{ request()->is('barang*') ? 'active' : '' }}">Barang</a>
                <a href="{{ route('peminjaman.index') }}"
                    class="{{ request()->is('peminjaman*') ? 'active' : '' }}">Peminjaman</a>
                <a href="#">Pengembalian</a>
                <a href="#" class="text-danger">Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>