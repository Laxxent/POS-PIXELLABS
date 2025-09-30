<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan - {{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .receipt {
            max-width: 300px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .store-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .store-address {
            font-size: 10px;
            margin-bottom: 5px;
        }
        .invoice-info {
            margin-bottom: 10px;
        }
        .items {
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .item-name {
            flex: 2;
        }
        .item-qty {
            flex: 1;
            text-align: center;
        }
        .item-price {
            flex: 1;
            text-align: right;
        }
        .total-section {
            text-align: right;
            margin-bottom: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
        }
        @media print {
            body { margin: 0; padding: 10px; }
            .receipt { border: none; max-width: none; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="store-name">TOKO POS</div>
            <div class="store-address">Jl. Contoh No. 123<br>Kota, Provinsi 12345</div>
            <div class="store-address">Telp: (021) 123-4567</div>
        </div>

        <div class="invoice-info">
            <div><strong>No. Invoice:</strong> {{ $sale->invoice_number }}</div>
            <div><strong>Tanggal:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</div>
            <div><strong>Kasir:</strong> {{ $sale->user->name ?? 'Sistem' }}</div>
            @if($sale->customer && $sale->customer->name != 'Pelanggan Umum')
            <div><strong>Customer:</strong> {{ $sale->customer->name }}</div>
            @endif
        </div>

        <div class="items">
            <div style="border-bottom: 1px solid #000; margin-bottom: 5px; padding-bottom: 2px;">
                <div class="item-row">
                    <div class="item-name"><strong>Item</strong></div>
                    <div class="item-qty"><strong>Qty</strong></div>
                    <div class="item-price"><strong>Total</strong></div>
                </div>
            </div>
            @foreach($sale->saleItems as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->product->name }}</div>
                <div class="item-qty">{{ $item->quantity }}</div>
                <div class="item-price">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
            </div>
            @if($item->discount_amount > 0)
            <div class="item-row" style="font-size: 10px; color: #666;">
                <div class="item-name">  Diskon</div>
                <div class="item-qty">-</div>
                <div class="item-price">-Rp {{ number_format($item->discount_amount, 0, ',', '.') }}</div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($sale->discount_amount > 0)
            <div class="total-row">
                <span>Diskon:</span>
                <span>-Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($sale->tax_amount > 0)
            <div class="total-row">
                <span>Pajak:</span>
                <span>Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Bayar:</span>
                <span>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</span>
            </div>
            @if($sale->change_amount > 0)
            <div class="total-row">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <div class="footer">
            <div>Metode Pembayaran: {{ strtoupper($sale->payment_method) }}</div>
            <div style="margin-top: 10px;">
                Terima kasih atas kunjungan Anda!<br>
                Barang yang sudah dibeli tidak dapat dikembalikan
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>

