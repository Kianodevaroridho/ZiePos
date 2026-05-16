@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div class="mb-4">
    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>{{ $transaction->invoice_number }}</span>
                <a href="{{ route('transactions.receipt', $transaction) }}" class="btn btn-sm btn-primary" target="_blank">
                    <i class="bi bi-printer me-1"></i> Cetak Struk
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold" style="font-size:1.1rem; color:var(--primary);">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Dibayar</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Kembalian</td>
                                <td class="text-end fw-semibold" style="color:var(--success);">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card fade-in fade-in-delay-1">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informasi</div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:0.85rem;">
                    <tr>
                        <td class="text-muted" style="width:40%;">Invoice</td>
                        <td class="fw-bold">{{ $transaction->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kasir</td>
                        <td>{{ $transaction->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode</td>
                        <td><span class="badge bg-{{ $transaction->payment_method === 'cash' ? 'success' : 'info' }}">{{ ucfirst($transaction->payment_method) }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu</td>
                        <td>{{ $transaction->created_at->format('H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
