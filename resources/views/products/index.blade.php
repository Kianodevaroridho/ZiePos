@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Daftar Produk</h4>
        <p>Kelola semua produk toko Anda</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
</div>

<!-- Filter -->
<div class="card mb-3 fade-in">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Cari Produk</label>
                <input type="text" name="search" class="form-control" placeholder="Nama atau SKU..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary flex-fill"><i class="bi bi-search me-1"></i> Filter</button>
                <a href="{{ route('products.index') }}" class="btn btn-light"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
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
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
                                @else
                                    <div style="width:40px;height:40px;border-radius:8px;background:linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);display:flex;align-items:center;justify-content:center;">
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
                                        <i class="bi {{ $icon }} text-primary"></i>
                                    </div>
                                @endif
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
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this, 'produk')"><i class="bi bi-trash3"></i></button>
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
