@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Daftar Produk</h4>
        <p>Kelola semua produk toko Anda</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-dark d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-expanded="false" aria-controls="searchCollapse" style="border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: 1.5px solid #E2E8F0; padding: 0.5rem 1.25rem;">
            <i class="bi bi-search text-secondary"></i> <span style="color: #475569;">Pencarian</span>
        </button>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    </div>
</div>

<!-- Collapsible Pencarian Block -->
<div class="collapse {{ request('search') || request('category') ? 'show' : '' }} mb-3" id="searchCollapse">
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #475569; margin-bottom: 0.4rem;">Cari Produk</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama atau SKU..." value="{{ request('search') }}" style="border-radius: 10px; height: 42px; font-size: 0.9rem; border: 1.5px solid #E2E8F0;">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #475569; margin-bottom: 0.4rem;">Kategori</label>
                    <select name="category" class="form-select" style="border-radius: 10px; height: 42px; font-size: 0.9rem; border: 1.5px solid #E2E8F0;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-dark flex-fill fw-bold" style="background: #0F172A; border-color: #0F172A; border-radius: 10px; height: 42px; font-size: 0.9rem;"><i class="bi bi-search me-1"></i> Cari</button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('products.index') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="border-radius: 10px; width: 42px; height: 42px;" title="Reset"><i class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card fade-in">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Produk</th>
                        <th>SKU</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $iconMap = [
                            'makanan' => 'bi-egg-fried',
                            'minuman' => 'bi-cup-hot',
                            'snack' => 'bi-cookie',
                            'cemilan' => 'bi-cookie',
                            'coffee' => 'bi-cup-straw',
                            'dessert' => 'bi-cake2',
                            'elektronik' => 'bi-laptop',
                            'pakaian' => 'bi-tag',
                        ];
                    @endphp
                    @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:8px;background:rgba(15, 23, 42, 0.07);color:#0F172A;display:flex;align-items:center;justify-content:center;font-size:0.95rem;flex-shrink:0;">
                                    @php
                                        $catName = strtolower($product->category->name ?? '');
                                        $icon = 'bi-box-seam';
                                        foreach($iconMap as $key => $val) {
                                            if(str_contains($catName, $key)) {
                                                $icon = $val;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <i class="bi {{ $icon }}"></i>
                                </div>
                                <span class="fw-semibold">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td><code>{{ $product->sku }}</code></td>
                        <td><span class="badge bg-light text-dark">{{ $product->category->name }}</span></td>
                        <td class="fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $product->stock <= 5 ? 'danger' : ($product->stock <= 20 ? 'warning' : 'success') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-dark" style="border-radius: 8px; background: #0F172A; border-color: #0F172A;"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" style="border-radius: 8px; background: #EF4444; border-color: #EF4444;" onclick="confirmDelete(this, 'produk')"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada produk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $products->withQueryString()->links() }}
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(button, type) {
    Swal.fire({
        title: 'Hapus ' + type + '?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#64748B',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endpush
