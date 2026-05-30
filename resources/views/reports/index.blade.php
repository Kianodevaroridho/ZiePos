@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="page-header mb-0">
        <h4>Laporan Penjualan</h4>
        <p>Analisis penjualan berdasarkan periode</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-3 fade-in">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary flex-fill"><i class="bi bi-filter me-1"></i> Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-light"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4 fade-in">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Penjualan</div>
                    <div class="stat-value" style="color:var(--primary);">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(79,70,229,0.1);color:var(--primary);"><i class="bi bi-wallet2"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 fade-in fade-in-delay-1">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value" style="color:var(--success);">{{ $totalTransactions }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(16,185,129,0.1);color:var(--success);"><i class="bi bi-receipt"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 fade-in fade-in-delay-2">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Rata-rata / Transaksi</div>
                    <div class="stat-value" style="color:var(--info);">Rp {{ $totalTransactions > 0 ? number_format($totalSales / $totalTransactions, 0, ',', '.') : 0 }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(6,182,212,0.1);color:var(--info);"><i class="bi bi-graph-up"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Top Products -->
    <div class="col-lg-5 fade-in">
        <div class="card">
            <div class="card-header"><i class="bi bi-trophy me-2"></i>Produk Terlaris</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $index => $item)
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: {{ $index < 3 ? '#0F172A' : '#E2E8F0' }}; color: {{ $index < 3 ? 'white' : 'var(--text-secondary)' }};">{{ $index + 1 }}</span>
                                </td>
                                <td class="fw-semibold">{{ $item->product->name ?? '-' }}</td>
                                <td class="text-center">{{ $item->total_qty }}</td>
                                <td class="text-end">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="col-lg-7 fade-in fade-in-delay-1">
        <div class="card">
            <div class="card-header"><i class="bi bi-list-ul me-2"></i>Daftar Transaksi</div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                    <table class="table table-hover mb-0">
                        <thead class="position-sticky top-0">
                            <tr>
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th class="text-end">Total</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr>
                                <td>
                                    <a href="{{ route('transactions.show', $trx) }}" class="fw-semibold text-decoration-none">{{ $trx->invoice_number }}</a>
                                </td>
                                <td>{{ $trx->user->name }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                <td style="font-size:0.8rem; color:var(--text-secondary);">{{ $trx->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Tidak ada transaksi pada periode ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
