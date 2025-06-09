<div class="sidebar bg-dark text-white vh-100" style="width: 240px;">
    <div class="p-4">
        <h4 class="fw-bold mb-4">SISFO SARPRAS</h4>

        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link text-white">
                    <i class="fas fa-tags me-2"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('barang.index') }}" class="nav-link text-white">
                    <i class="fas fa-box me-2"></i> Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('stok.index') }}" class="nav-link text-white">
                    <i class="fas fa-chart-line me-2"></i> Stok
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('peminjaman.index') }}" class="nav-link text-white">
                    <i class="fas fa-arrow-down me-2"></i> Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pengembalian.index') }}" class="nav-link text-white">
                    <i class="fas fa-arrow-up me-2"></i> Pengembalian
                </a>
            </li>

            <hr class="bg-secondary">

            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<style>
    .btn-logout {
        background: none;
        border: none;
        padding: 8px 0;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-logout:hover {
        background-color: #1a1a1a;
    }
</style>

<!-- Tambahkan Font Awesome jika belum -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
