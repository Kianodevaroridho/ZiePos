@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Riwayat Transaksi</h4>
        <p>Daftar semua transaksi penjualan</p>
    </div>
    <!-- Beautiful, clean outline Pencarian toggle button flush on the far right -->
    <button class="btn btn-outline-dark d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-expanded="false" aria-controls="searchCollapse" style="border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: 1.5px solid #E2E8F0; padding: 0.5rem 1rem;">
        <i class="bi bi-search text-secondary"></i> <span style="color: #475569;">Pencarian</span>
    </button>
</div>

<!-- Collapsible Pencarian Block -->
<div class="collapse {{ request('search') || request('date') ? 'show' : '' }} mb-3" id="searchCollapse">
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #475569; margin-bottom: 0.4rem;">Cari Invoice</label>
                    <input type="text" name="search" class="form-control" placeholder="No. Invoice..." value="{{ request('search') }}" style="border-radius: 10px; height: 42px; font-size: 0.9rem; border: 1.5px solid #E2E8F0;">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size: 0.8rem; color: #475569; margin-bottom: 0.4rem;">Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="border-radius: 10px; height: 42px; font-size: 0.9rem; border: 1.5px solid #E2E8F0;">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-dark flex-fill fw-bold" style="background: #0F172A; border-color: #0F172A; border-radius: 10px; height: 42px; font-size: 0.9rem;"><i class="bi bi-search me-1"></i> Cari</button>
                    @if(request('search') || request('date'))
                        <a href="{{ route('transactions.index') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="border-radius: 10px; width: 42px; height: 42px;" title="Reset"><i class="bi bi-x-lg"></i></a>
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
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Metode</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $index => $trx)
                    <tr>
                        <td>{{ $transactions->firstItem() + $index }}</td>
                        <td><span class="fw-bold" style="color: var(--primary);">{{ $trx->invoice_number }}</span></td>
                        <td>{{ $trx->user->name }}</td>
                        <td class="fw-bold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trx->paid_amount, 0, ',', '.') }}</td>
                        <td style="color:var(--success);">Rp {{ number_format($trx->change_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($trx->payment_method === 'cash')
                                <span class="badge d-inline-flex align-items-center gap-1 py-1.5 px-2.5" style="background: #F1F5F9; color: #0F172A; border: 1.5px solid #E2E8F0; font-size: 0.72rem; font-weight: 700; border-radius: 6px;">
                                    <i class="bi bi-cash" style="font-size: 0.8rem;"></i> Cash
                                </span>
                            @else
                                <span class="badge d-inline-flex align-items-center gap-1 py-1.5 px-2.5" style="background: #F1F5F9; color: #0F172A; border: 1.5px solid #E2E8F0; font-size: 0.72rem; font-weight: 700; border-radius: 6px;">
                                    <i class="bi bi-credit-card" style="font-size: 0.8rem;"></i> Transfer
                                </span>
                            @endif
                        </td>
                        <td style="font-size:0.8rem; color:var(--text-secondary);">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('transactions.show', $trx) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $transactions->withQueryString()->links() }}
</div>
@endsection
