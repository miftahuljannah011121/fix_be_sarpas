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
            background-color: #f5f6fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(to bottom right, #bd0298, #ff87c6);
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 15px;
            border-left: 4px solid transparent;
            border-radius: 0 20px 20px 0;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            font-weight: bold;
            border-left-color: #fff;
        }

        .sidebar .nav-link i {
            font-size: 18px;
            margin-right: 10px;
        }

        .sidebar .brand {
            background-color: #fff;
            padding: 1rem;
            text-align: center;
            color: #bd0298;
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 1px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .logout-btn {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            padding-top: 1rem;
        }

        .logout-btn .nav-link {
            color: #ffc9de;
        }

        .logout-btn .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(189, 2, 152, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-flex flex-column p-0">
                <div class="brand">SISFO SARPRAS</div>
                <div class="nav flex-column px-2 mt-3">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> User
                    </a>
                    <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                        <i class="bi bi-tag"></i> Kategori
                    </a>
                    <a href="{{ route('barang.index') }}" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                        <i class="bi bi-box"></i> Barang
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-down-circle"></i> Peminjaman
                    </a>
                    <a href="{{ route('pengembalian.index') }}" class="nav-link {{ request()->is('pengembalian*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-up-circle"></i> Pengembalian
                    </a>
                    <a href="{{ route('laporan.peminjaman') }}" class="nav-link {{ request()->is('laporan/peminjaman*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> Laporan Peminjaman
                    </a>
                    <a href="{{ route('laporan.pengembalian') }}" class="nav-link {{ request()->is('laporan/pengembalian*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check"></i> Laporan Pengembalian
                    </a>
                </div>
                <div class="logout-btn px-2 mt-4">
                    <a href="#" class="nav-link">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 py-4 px-4">
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
