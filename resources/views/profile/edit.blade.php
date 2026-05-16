@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row g-4">
    {{-- Profile Header --}}
    <div class="col-12 fade-in">
        <div class="card" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none;">
            <div class="card-body d-flex align-items-center gap-4 py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width: 72px; height: 72px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-size: 1.75rem; font-weight: 800; flex-shrink: 0; border: 3px solid rgba(255,255,255,0.3);">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h4 class="mb-1 text-white fw-bold">{{ $user->name }}</h4>
                    <p class="mb-0" style="color: rgba(255,255,255,0.75); font-size: 0.875rem;">
                        <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                    </p>
                    <span class="badge mt-2" style="background: rgba(255,255,255,0.2); color: white; font-size: 0.7rem; backdrop-filter: blur(10px);">
                        <i class="bi bi-shield-check me-1"></i>{{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Profile Information --}}
    <div class="col-lg-6 fade-in fade-in-delay-1">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-person-gear me-2"></i>Informasi Profil
            </div>
            <div class="card-body">
                <p style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                    Perbarui nama dan alamat email akun kamu.
                </p>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <span class="text-success" style="font-size: 0.8rem; font-weight: 500;">
                                <i class="bi bi-check-circle-fill me-1"></i>Tersimpan!
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Password --}}
    <div class="col-lg-6 fade-in fade-in-delay-2">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-key me-2"></i>Ubah Password
            </div>
            <div class="card-body">
                <p style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                    Pastikan akun kamu menggunakan password yang kuat dan aman.
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                               id="current_password" name="current_password" autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                               id="password" name="password" autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-shield-lock me-1"></i>Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <span class="text-success" style="font-size: 0.8rem; font-weight: 500;">
                                <i class="bi bi-check-circle-fill me-1"></i>Password diperbarui!
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
