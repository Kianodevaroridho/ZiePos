@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Tambah Kategori</h4>
        <p>Buat kategori baru untuk mengelompokkan produk Anda</p>
    </div>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark d-flex align-items-center gap-2" style="border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: 1.5px solid #E2E8F0; padding: 0.5rem 1.25rem;">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru
            </div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
