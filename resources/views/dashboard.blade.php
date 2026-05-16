@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6 fade-in">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Penjualan Hari Ini</div>
                    <div class="stat-value" style="color: var(--primary);">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 fade-in fade-in-delay-1">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Transaksi Hari Ini</div>
                    <div class="stat-value" style="color: var(--success);">{{ $todayTransactions }}</div>
                </div>
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 fade-in fade-in-delay-2">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Produk Aktif</div>
                    <div class="stat-value" style="color: var(--info);">{{ $totalProducts }}</div>
                </div>
                <div class="stat-icon" style="background: rgba(6, 182, 212, 0.1); color: var(--info);">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 fade-in fade-in-delay-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-value" style="color: var(--danger);">{{ $lowStockProducts }}</div>
                </div>
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Sales Chart -->
    <div class="col-lg-8 fade-in">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up me-2"></i>Penjualan 7 Hari Terakhir</span>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="280"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-4 fade-in fade-in-delay-1">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-trophy me-2"></i>Produk Terlaris
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $index => $product)
                    <div class="list-group-item d-flex align-items-center gap-3 border-0 py-3 px-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:32px; height:32px; background: {{ $index < 3 ? 'linear-gradient(135deg, var(--primary), var(--secondary))' : '#E2E8F0' }}; color: {{ $index < 3 ? 'white' : 'var(--text-secondary)' }}; font-size: 0.75rem; font-weight: 700; flex-shrink:0;">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-semibold text-truncate" style="font-size: 0.85rem;">{{ $product->name }}</div>
                            <div style="font-size: 0.7rem; color: var(--text-secondary);">Terjual: {{ $product->total_sold ?? 0 }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Belum ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row g-3 mt-1">
    <div class="col-12 fade-in">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</span>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $trx)
                            <tr>
                                <td><span class="fw-semibold">{{ $trx->invoice_number }}</span></td>
                                <td>{{ $trx->user->name }}</td>
                                <td class="fw-bold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $trx->payment_method === 'cash' ? 'success' : 'info' }}">
                                        {{ ucfirst($trx->payment_method) }}
                                    </span>
                                </td>
                                <td style="color: var(--text-secondary); font-size:0.8rem;">{{ $trx->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="empty-state">
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 280);
gradient.addColorStop(0, 'rgba(79, 70, 229, 0.3)');
gradient.addColorStop(1, 'rgba(79, 70, 229, 0.01)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($salesChart)->pluck('date')) !!},
        datasets: [{
            label: 'Penjualan (Rp)',
            data: {!! json_encode(collect($salesChart)->pluck('total')) !!},
            borderColor: '#4F46E5',
            backgroundColor: gradient,
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#4F46E5',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    },
                    font: { size: 11 }
                },
                grid: { color: 'rgba(0,0,0,0.04)' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});
</script>
@endpush
