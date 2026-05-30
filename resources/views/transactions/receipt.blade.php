<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 13px; color: #111; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .wrapper { display: flex; flex-direction: column; align-items: center; }
        .receipt { background: #fff; width: 340px; padding: 30px 24px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .center { text-align: center; }
        .logo { background: #000; color: #fff; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; margin: 0 auto 12px; }
        .store-name { font-size: 18px; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 6px; }
        .store-info { font-size: 12px; color: #4b5563; line-height: 1.4; margin-bottom: 4px; }
        hr { border: 0; height: 0; margin: 12px 0; }
        hr.solid { border-top: 1.5px solid #000; }
        hr.dashed { border-top: 1px dashed #9ca3af; }
        .row { display: flex; justify-content: space-between; margin: 6px 0; }
        .bold { font-weight: 600; }
        .item-row { margin-bottom: 12px; }
        .item-qty { font-size: 11px; color: #6b7280; margin-top: 2px; }
        .total-row { font-size: 15px; font-weight: 700; color: #000; }
        .footer { font-size: 12px; color: #4b5563; line-height: 1.5; margin-top: 16px; }
        .btn-container { display: flex; gap: 10px; margin-top: 20px; width: 340px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 20px; font-size: 12px; font-weight: 600; cursor: pointer; border-radius: 6px; text-decoration: none; flex: 1; border: 1px solid #e5e7eb; transition: 0.15s; }
        .btn-primary { background: #000; color: #fff; border-color: #000; }
        .btn-primary:hover { background: #222; }
        .btn-secondary { background: #fff; color: #374151; }
        .btn-secondary:hover { background: #f9fafb; }
        @media print {
            body { background: #fff; padding: 0; min-height: auto; justify-content: flex-start; align-items: flex-start; }
            .receipt { width: 80mm; border: none; box-shadow: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="receipt">
            <div class="center">
                <div class="logo">Z</div>
                <div class="store-name">ZIE POS</div>
                <div class="store-info">Jl. Siliwangi No. 123, Cianjur</div>
                <div class="store-info">Telp: 0812-3456-7890</div>
            </div>
            <hr class="solid">
            <div class="row"><span>Invoice</span><span class="bold">{{ $transaction->invoice_number }}</span></div>
            <div class="row"><span>Tanggal</span><span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span></div>
            <div class="row"><span>Kasir</span><span>{{ $transaction->user->name }}</span></div>
            <hr class="dashed">
            <div class="item-list">
                @foreach($transaction->items as $item)
                <div class="item-row">
                    <div class="row">
                        <span class="bold">{{ $item->product->name ?? '-' }}</span>
                        <span class="bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="item-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
            <hr class="dashed">
            <div class="row"><span>Subtotal</span><span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span></div>
            <hr class="solid">
            <div class="row total-row"><span>TOTAL</span><span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span></div>
            <div class="row"><span>{{ $transaction->payment_method === 'cash' ? 'Tunai' : 'Transfer' }}</span><span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span></div>
            <div class="row"><span>Kembalian</span><span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span></div>
            <hr class="dashed">
            <div class="center footer">
                <div class="bold">Terima kasih atas kunjungan Anda</div>
                <div style="font-size: 11px;">Barang yang sudah dibeli tidak dapat ditukar</div>
                <div style="margin-top: 12px; font-size: 11px;">ZiePos System</div>
            </div>
        </div>
        <div class="btn-container no-print">
            <a href="{{ route('pos.index') }}" class="btn btn-secondary" onclick="if(window.opener || window.history.length > 1) { window.close(); return false; }">Tutup</a>
            <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
        </div>
    </div>
    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
