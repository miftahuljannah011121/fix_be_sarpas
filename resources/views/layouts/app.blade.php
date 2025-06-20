<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISFO SARPRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
    min-height: 100vh;
    background-color:rgb(189, 2, 152);
}

.sidebar a {
    color: #ffffff;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-left: 4px solid transparent;
    font-size: 15px;
    transition: background-color 0.2s, border-left-color 0.2s;
}

.sidebar a:hover {
    background-color: rgb(159, 21, 120);
}

.sidebar a.active {
    background-color:rgb(255, 0, 191);
    border-left-color: #0d6efd;
    font-weight: bold;
}

.sidebar a i {
    font-size: 18px;
}

    </style>


</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="py-3 px-3 mb-3">
                    <h5 class="text-white mb-0">SISFO SARPRAS</h5>
                </div>
                <div class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('user.index') }}" class="{{ request()->is('user*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> User
                    </a>
                    <a href="{{ route('kategori.index') }}" class="{{ request()->is('kategori*') ? 'active' : '' }}">
                        <i class="bi bi-tag me-2"></i> Kategori
                    </a>
                    <a href="{{ route('barang.index') }}" class="{{ request()->is('barang*') ? 'active' : '' }}">
                        <i class="bi bi-box me-2"></i> Barang
                    </a>
                    <a href="{{ route('peminjaman.index') }}"
                        class="{{ request()->is('peminjaman*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-down-circle me-2"></i> Peminjaman
                    </a>
                    <a href="{{ route('pengembalian.index') }}"
                        class="{{ request()->is('pengembalian*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-up-circle me-2"></i> Pengembalian
                    </a>
                    <a href="#" class="mt-3 text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 py-3 px-4">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>