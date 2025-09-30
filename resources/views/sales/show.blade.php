@extends('layouts.app')

@section('title', 'Detail Penjualan - POS Application')
@section('page-title', 'Detail Penjualan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-receipt me-2"></i>
                    Detail Transaksi Penjualan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Informasi Transaksi</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>No. Invoice:</strong></td>
                                <td>{{ $sale->invoice_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal:</strong></td>
                                <td>{{ $sale->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer:</strong></td>
                                <td>{{ $sale->customer->name ?? 'Pelanggan Umum' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kasir:</strong></td>
                                <td>{{ $sale->user->name ?? 'Sistem' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge {{ $sale->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Informasi Pembayaran</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td>Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @if($sale->discount_amount > 0)
                            <tr>
                                <td><strong>Diskon:</strong></td>
                                <td class="text-danger">- Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if($sale->tax_amount > 0)
                            <tr>
                                <td><strong>Pajak:</strong></td>
                                <td>Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr class="table-active">
                                <td><strong>Total:</strong></td>
                                <td><strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Metode Pembayaran:</strong></td>
                                <td>{{ ucfirst($sale->payment_method) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Bayar:</strong></td>
                                <td>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                            </tr>
                            @if($sale->change_amount > 0)
                            <tr>
                                <td><strong>Kembalian:</strong></td>
                                <td class="text-success">Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($sale->notes)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Catatan</h5>
                        <p class="text-muted">{{ $sale->notes }}</p>
                    </div>
                </div>
                @endif

                <hr>

                <h5>Item yang Dibeli</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                @if($sale->discount_amount > 0)
                                <th>Diskon</th>
                                @endif
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->image && file_exists(public_path('storage/' . $item->product->image)))
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="img-thumbnail me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name }}</strong>
                                            @if($item->product->code)
                                                <br><small class="text-muted">Kode: {{ $item->product->code }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }} {{ $item->product->unit->symbol ?? '' }}</td>
                                <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                @if($sale->discount_amount > 0)
                                <td>
                                    @if($item->discount_amount > 0)
                                        Rp {{ number_format($item->discount_amount, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                @endif
                                <td><strong>Rp {{ number_format($item->total_price, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="{{ $sale->discount_amount > 0 ? '5' : '4' }}"><strong>Total</strong></td>
                                <td><strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('sales.receipt', $sale) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-print me-1"></i> Cetak Struk
                        </a>
                        @if($sale->status == 'pending')
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
