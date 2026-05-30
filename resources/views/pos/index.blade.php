@extends('layouts.app')
@section('title', 'Kasir (POS)')

@push('styles')
<style>
    .pos-product-card {
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1.5px solid transparent !important;
        background: white;
        height: 100%;
    }
    .pos-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        border-color: var(--primary) !important;
    }
    .pos-product-card .rounded-circle {
        transition: transform 0.25s ease;
    }
    .pos-product-card:hover .rounded-circle {
        transform: scale(1.12);
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
        color: #0F172A;
        opacity: 0.8;
    }
    .pos-product-card .overlay-add {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.4);
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
        <!-- Search & Category Filters -->
        <div class="card mb-3 border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-3">
                <!-- Search bar -->
                <form method="GET" action="{{ route('pos.index') }}" class="mb-3">
                    <div class="input-group" style="border-radius: 12px; overflow: hidden; background: #F8FAFC; border: 1.5px solid #E2E8F0;">
                        <span class="input-group-text bg-transparent border-0 pe-1"><i class="bi bi-search text-secondary"></i></span>
                        <input type="text" name="search" class="form-control bg-transparent border-0" placeholder="Cari produk berdasarkan nama atau SKU..." value="{{ request('search') }}" style="height: 46px; font-size: 0.95rem; color: #0F172A; box-shadow: none !important;">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <a href="{{ route('pos.index', ['category' => request('category')]) }}" class="btn bg-transparent border-0 d-flex align-items-center justify-content-center px-3" style="box-shadow: none !important;"><i class="bi bi-x-lg text-secondary" style="font-size:0.9rem;"></i></a>
                        @endif
                    </div>
                </form>

                <!-- Horizontal scrollable categories with filled icons -->
                <div class="d-flex align-items-center gap-2 overflow-x-auto pb-1 category-scroll" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .category-scroll::-webkit-scrollbar {
                            display: none;
                        }
                        .category-pill {
                            display: flex;
                            align-items: center;
                            gap: 0.4rem;
                            padding: 0.45rem 1rem;
                            border-radius: 50rem;
                            background: #F1F5F9;
                            color: #475569;
                            font-weight: 500;
                            font-size: 0.8rem;
                            border: 1.5px solid transparent;
                            text-decoration: none !important;
                            white-space: nowrap;
                            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                        .category-pill:hover {
                            background: #E2E8F0;
                            color: #0F172A;
                        }
                        .category-pill.active {
                            background: #0F172A !important;
                            color: #FFFFFF !important;
                            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
                        }
                        .category-pill i {
                            font-size: 0.95rem;
                        }
                    </style>

                    <a href="{{ route('pos.index', ['search' => request('search')]) }}" class="category-pill {{ !request('category') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i>
                        <span>Semua</span>
                    </a>

                    @foreach($categories as $cat)
                        @php
                            $catName = strtolower($cat->name);
                            $icon = 'bi-tag';
                            if (str_contains($catName, 'makanan')) {
                                $icon = 'bi-egg-fried';
                            } elseif (str_contains($catName, 'minuman') || str_contains($catName, 'drink')) {
                                $icon = 'bi-cup-hot';
                            } elseif (str_contains($catName, 'snack') || str_contains($catName, 'cemilan') || str_contains($catName, 'cookie')) {
                                $icon = 'bi-cookie';
                            } elseif (str_contains($catName, 'coffee') || str_contains($catName, 'kopi')) {
                                $icon = 'bi-cup-straw';
                            } elseif (str_contains($catName, 'dessert') || str_contains($catName, 'kue')) {
                                $icon = 'bi-cake2';
                            } elseif (str_contains($catName, 'elektronik') || str_contains($catName, 'gadget')) {
                                $icon = 'bi-laptop';
                            } elseif (str_contains($catName, 'pakaian') || str_contains($catName, 'baju')) {
                                $icon = 'bi-tag';
                            }
                        @endphp
                        <a href="{{ route('pos.index', ['category' => $cat->id, 'search' => request('search')]) }}" class="category-pill {{ request('category') == $cat->id ? 'active' : '' }}">
                            <i class="bi {{ $icon }}"></i>
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-3">
            @forelse($products as $product)
            <div class="col-6 col-md-4 col-xl-3">
                <form action="{{ route('pos.cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="card pos-product-card w-100 text-start shadow-sm" style="border-radius: 12px; padding: 0.85rem;">
                        <div class="d-flex align-items-center gap-2 mb-2">
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
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.85rem; background: rgba(15, 23, 42, 0.07); color: #0F172A; flex-shrink:0;">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            @if($product->category)
                                <span class="badge bg-light text-dark px-2 py-1" style="font-size: 0.65rem; font-weight: 600; background-color: #F1F5F9 !important;">{{ $product->category->name }}</span>
                            @endif
                            @if($product->stock <= 5)
                                <span class="badge bg-danger text-white px-2 py-1 ms-auto" style="font-size: 0.65rem; font-weight: 700;">Limit</span>
                            @endif
                        </div>
                        <div class="fw-bold text-truncate mb-1" style="font-size:0.92rem; color: var(--text-primary);">{{ $product->name }}</div>
                        <div class="fw-bold text-primary" style="font-size:1.05rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
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
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <form action="{{ route('pos.cart.update') }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <div class="d-flex align-items-center" style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 8px; padding: 0.25rem 0.5rem;">
                                    <span class="text-secondary me-1" style="font-size: 0.75rem; font-weight: 600;">Qty:</span>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()" class="qty-input border-0 bg-transparent text-center fw-bold" style="width: 38px; font-size: 0.85rem; outline: none; box-shadow: none !important; padding: 0; height: auto;">
                                </div>
                            </form>
                            <form action="{{ route('pos.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <button class="btn btn-sm btn-light border text-danger d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border-radius: 8px; font-size: 0.8rem; transition: all 0.2s;" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px; background: rgba(15, 23, 42, 0.05); color: #94A3B8;">
                            <i class="bi bi-cart-dash" style="font-size: 1.75rem;"></i>
                        </div>
                        <p class="fw-semibold text-dark mb-1" style="font-size:0.9rem;">Keranjang Masih Kosong</p>
                        <p class="text-muted mb-0" style="font-size:0.75rem;">Pilih produk di sebelah kiri untuk ditambahkan</p>
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
                        <button type="button" class="btn btn-dark w-100 fw-bold py-2.5" id="btnCheckout" style="background: #0F172A; border-color: #0F172A; border-radius: 10px; font-size: 0.95rem; transition: all 0.2s;">
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
        confirmButtonColor: '#0F172A',
        cancelButtonColor: '#64748B',
        confirmButtonText: 'Ya, Bayar Sekarang',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: { popup: 'swal-ziepos' }
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
