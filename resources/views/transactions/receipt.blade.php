<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $transaction->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 300px; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin: 2px 0; }
        .store-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        h3 { margin: 5px 0; }
        @media print {
            body { width: 80mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="store-name">ZiePos</div>
        <div>Jl. Contoh No. 123</div>
        <div>Telp: 0812-3456-7890</div>
    </div>

    <div class="line"></div>

    <div class="row">
        <span>No:</span>
        <span class="bold">{{ $transaction->invoice_number }}</span>
    </div>
    <div class="row">
        <span>Tanggal:</span>
        <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="row">
        <span>Kasir:</span>
        <span>{{ $transaction->user->name }}</span>
    </div>

    <div class="line"></div>

    @foreach($transaction->items as $item)
    <div style="margin-bottom: 4px;">
        <div class="bold">{{ $item->product->name ?? '-' }}</div>
        <div class="row">
            <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
    </div>
    @endforeach

    <div class="line"></div>

    <div class="row bold">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
    </div>
    <div class="row">
        <span>Bayar ({{ ucfirst($transaction->payment_method) }})</span>
        <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
    </div>
    <div class="row">
        <span>Kembali</span>
        <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
    </div>

    <div class="line"></div>

    <div class="center" style="margin-top:10px;">
        <div>Terima kasih atas kunjungan Anda!</div>
        <div style="margin-top: 5px; font-size: 10px;">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 8px 24px; font-size: 14px; cursor: pointer; background: #4F46E5; color: white; border: none; border-radius: 8px;">
            🖨️ Cetak Struk
        </button>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
