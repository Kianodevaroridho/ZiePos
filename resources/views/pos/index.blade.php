@extends('layouts.app')
@section('title', 'Kasir (POS)')

@push('styles')
<style>
    .pos-product-card {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        overflow: hidden;
        background: white;
        height: 100%;
    }
    .pos-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(79, 70, 229, 0.2);
    }
    .pos-product-card .product-img-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1/1;
    }
    .pos-product-card .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .pos-product-card:hover .product-img {
        transform: scale(1.1);
    }
    .pos-product-card .product-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #4F46E5;
        opacity: 0.8;
    }
    .pos-product-card .overlay-add {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(79, 70, 229, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(2px);
    }
    .pos-product-card:hover .overlay-add {
        opacity: 1;
    }
    .btn-add-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: white;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }
    .pos-product-card:hover .btn-add-circle {
        transform: scale(1);
    }
    .category-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(4px);
        color: var(--primary);
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .stock-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 600;
        z-index: 2;
    }
    .cart-section {
        position: sticky;
        top: 80px;
    }
    .cart-item {
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    .cart-item:last-child {
        border-bottom: none;
    }
    .qty-input {
        width: 55px;
        text-align: center;
        border-radius: 8px;
        border: 1.5px solid var(--border-color);
        padding: 0.25rem;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
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
<div class="row g-3">
    <!-- Products Section -->
    <div class="col-lg-8">
        <!-- Search & Filter -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari produk..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-3">
            @forelse($products as $product)
            <div class="col-6 col-md-4 col-xl-3">
                <form action="{{ route('pos.cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="card pos-product-card w-100 text-start" style="background:none;">
                        <div class="product-img-wrapper">
                            @if($product->category)
                                <span class="category-badge">{{ $product->category->name }}</span>
                            @endif
                            
                            @if($product->stock <= 5)
                                <span class="stock-badge bg-danger text-white">Limit</span>
                            @endif

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                            @else
                                <div class="product-placeholder">
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
                            @endif
                            
                            <div class="overlay-add">
                                <div class="btn-add-circle">
                                    <i class="bi bi-plus-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 bg-white">
                            <div class="fw-bold text-truncate" style="font-size:0.85rem; color: var(--text-primary);">{{ $product->name }}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="fw-bold text-primary" style="font-size:0.9rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="text-muted" style="font-size:0.7rem;">S: {{ $product->stock }}</div>
                            </div>
                        </div>
                    </button>
                </form>
            </div>
            @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5 text-muted">
                        <i class="bi bi-search" style="font-size:3rem;"></i>
                        <p class="mt-2">Produk tidak ditemukan</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Cart Section -->
    <div class="col-lg-4">
        <div class="cart-section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cart3 me-2"></i>Keranjang</span>
                    @if(count($cart) > 0)
                    <form action="{{ route('pos.cart.clear') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash3"></i></button>
                    </form>
                    @endif
                </div>
                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                    @forelse($cart as $productId => $item)
                    <div class="cart-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="font-size:0.85rem;">{{ $item['name'] }}</div>
                                <div style="font-size:0.75rem; color:var(--text-secondary);">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }} x {{ $item['quantity'] }}
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold" style="font-size:0.85rem;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <form action="{{ route('pos.cart.update') }}" method="POST" class="d-flex align-items-center gap-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input">
                                <button class="btn btn-sm btn-outline-primary" style="padding:0.15rem 0.4rem; font-size:0.7rem;"><i class="bi bi-check-lg"></i></button>
                            </form>
                            <form action="{{ route('pos.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <button class="btn btn-sm btn-outline-danger" style="padding:0.15rem 0.4rem; font-size:0.7rem;"><i class="bi bi-x-lg"></i></button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-cart-x" style="font-size:2.5rem;"></i>
                        <p class="mt-2 mb-0" style="font-size:0.85rem;">Keranjang kosong</p>
                        <p style="font-size:0.75rem;">Klik produk untuk menambahkan</p>
                    </div>
                    @endforelse
                </div>

                @if(count($cart) > 0)
                @php $cartTotal = collect($cart)->sum('subtotal'); @endphp
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold" style="font-size:1.1rem;">Total</span>
                        <span class="fw-bold" style="font-size:1.25rem; color:var(--primary);">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('pos.checkout') }}" method="POST" id="checkoutForm">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label" style="font-size:0.8rem;">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select form-select-sm" required>
                                <option value="cash">💵 Cash</option>
                                <option value="transfer">💳 Transfer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size:0.8rem;">Jumlah Bayar</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="paid_amount" class="form-control" id="paidAmount" min="{{ $cartTotal }}" required placeholder="0">
                            </div>
                            <div id="changeDisplay" class="mt-1" style="font-size:0.8rem; color:var(--success); font-weight:600;"></div>
                        </div>
                        <button type="button" class="btn btn-success w-100" id="btnCheckout">
                            <i class="bi bi-check-circle me-1"></i> Bayar Sekarang
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('btnCheckout')?.addEventListener('click', function() {
    Swal.fire({
        title: 'Proses Transaksi?',
        text: "Pastikan jumlah pembayaran sudah benar.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#64748B',
        confirmButtonText: 'Ya, Bayar Sekarang!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('checkoutForm').submit();
        }
    });
});

document.getElementById('paidAmount')?.addEventListener('input', function() {
    const total = {{ $cartTotal ?? 0 }};
    const paid = parseFloat(this.value) || 0;
    const change = paid - total;
    const display = document.getElementById('changeDisplay');
    if (paid >= total && paid > 0) {
        display.innerHTML = 'Kembalian: Rp ' + new Intl.NumberFormat('id-ID').format(change);
        display.style.color = 'var(--success)';
    } else if (paid > 0) {
        display.innerHTML = 'Kurang: Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(change));
        display.style.color = 'var(--danger)';
    } else {
        display.innerHTML = '';
    }
});
</script>
@endpush
