@extends('layouts.app')

@section('content')
<style>
    .card {
        background-color: #fff0f8;
        color: #5a0050;
        border: none;
        box-shadow: 0 0 10px rgba(189, 2, 152, 0.2);
    }

    .card-header {
        background-color: rgb(189, 2, 152);
        color: #fff;
    }

    .table {
        color: #5a0050;
    }

    .table thead {
        background-color: rgb(255, 182, 232);
    }

    .btn-success {
        background-color: rgb(255, 0, 191);
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background-color: rgb(220, 0, 160);
    }

    .btn-warning {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
        border: none;
    }

    .btn-warning:hover {
        background-color: rgb(235, 152, 202);
    }

    .btn-danger {
        background-color: rgb(189, 2, 152);
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: rgb(159, 1, 127);
    }

    .alert-success {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
    }

    .alert-danger {
        background-color: rgb(255, 204, 221);
        color: #5a0050;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Daftar Pengguna</h4>
    </div>
    <div class="card-body">
        @if(session('berhasil'))
            <div class="alert alert-success mb-4">
                {{ session('berhasil') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('user.create') }}" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Pengguna
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
