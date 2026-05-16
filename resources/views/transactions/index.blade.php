@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Riwayat Transaksi</h4>
        <p>Daftar semua transaksi penjualan</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-3 fade-in">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Cari Invoice</label>
                <input type="text" name="search" class="form-control" placeholder="No. Invoice..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary flex-fill"><i class="bi bi-search me-1"></i> Filter</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-light"><i class="bi bi-x-lg"></i></a>
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
                        <td><span class="badge bg-{{ $trx->payment_method === 'cash' ? 'success' : 'info' }}">{{ ucfirst($trx->payment_method) }}</span></td>
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
