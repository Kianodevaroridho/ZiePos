@extends('layouts.app')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Kategori Produk</h4>
        <p>Kelola semua kategori produk Anda</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card fade-in">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Produk</th>
                        <th>Deskripsi</th>
                        <th style="width: 150px;">Aksi</th>
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
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:8px;background:rgba(15, 23, 42, 0.07);display:flex;align-items:center;justify-content:center;color:#0F172A;">
                                    @php
                                        $catName = strtolower($category->name);
                                        $icon = 'bi-tag-fill';
                                        foreach($iconMap as $key => $val) {
                                            if(str_contains($catName, $key)) {
                                                $icon = $val;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <i class="bi {{ $icon }}"></i>
                                </div>
                                <span class="fw-semibold">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $category->slug }}</span></td>
                        <td><span class="badge" style="background: #F1F5F9; color: #0F172A; border: 1px solid #E2E8F0; font-weight: 600;">{{ $category->products_count }} produk</span></td>
                        <td style="font-size:0.85rem; color: var(--text-secondary);">{{ Str::limit($category->description, 50) ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-dark" style="border-radius: 8px; background: #0F172A; border-color: #0F172A;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" style="border-radius: 8px; background: #EF4444; border-color: #EF4444;" onclick="confirmDelete(this, 'kategori')"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada kategori</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $categories->links() }}
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
        confirmButtonColor: '#0F172A',
        cancelButtonColor: '#64748B',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: { popup: 'swal-ziepos' }
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endpush
