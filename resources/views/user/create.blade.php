@extends('layouts.app')

@section('content')
<style>
    .form-label {
        font-weight: 500;
        color: #5a0050;
    }
    .form-control:focus {
        border-color: #bd0298;
        box-shadow: 0 0 0 0.15rem rgba(189, 2, 152, 0.25);
    }
    .btn-pink {
        background-color: #bd0298;
        border: none;
        color: white;
        transition: background-color 0.2s ease-in-out;
    }
    .btn-pink:hover {
        background-color: #a10281;
    }
</style>

<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px; background-color: #fff0f8; border: none;">
        <div class="card-body">
            <h4 class="mb-4 text-center fw-bold text-pink">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
            </h4>

            <form action="{{ route('user.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-pink w-100">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
