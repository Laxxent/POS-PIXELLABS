@extends('layouts.app')

@section('title', 'Detail Produk - POS Application')
@section('page-title', 'Detail Produk')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-eye me-2"></i>
                    Detail Produk
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                                 style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $product->name }}</h4>
                        <hr>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Kode Produk:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $product->code ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>Barcode:</strong>
                            </div>
                            <div class="col-sm-8">
                                @if($product->barcode)
                                    <code>{{ $product->barcode }}</code>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>SKU:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $product->sku ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>Kategori:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>Satuan:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $product->unit->name }} ({{ $product->unit->symbol }})
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>Supplier:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $product->supplier ? $product->supplier->name : '-' }}
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-sm-8">
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                        
                        @if($product->description)
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <strong>Deskripsi:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $product->description }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Pricing Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-dollar-sign me-2"></i>
                    Informasi Harga
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Harga Beli:</span>
                        <strong>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Harga Jual:</span>
                        <strong>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Harga Grosir:</span>
                        <strong>Rp {{ number_format($product->wholesale_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @if($product->price)
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Harga Lainnya:</span>
                        <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Stock Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-boxes me-2"></i>
                    Informasi Stok
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Stok Saat Ini:</span>
                        <strong class="{{ $product->isLowStock() ? 'text-danger' : 'text-success' }}">
                            {{ $product->stock }} {{ $product->unit->symbol }}
                        </strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Stok Minimum:</span>
                        <strong>{{ $product->min_stock }} {{ $product->unit->symbol }}</strong>
                    </div>
                </div>
                @if($product->isLowStock())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Stok rendah! Segera restock produk ini.
                </div>
                @endif
            </div>
        </div>
        
        <!-- Product Features -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="fas fa-cogs me-2"></i>
                    Fitur Produk
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <i class="fas {{ $product->has_serial_number ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                    Memiliki Nomor Seri
                </div>
                <div class="mb-2">
                    <i class="fas {{ $product->barcode ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                    Memiliki Barcode
                </div>
                <div class="mb-2">
                    <i class="fas {{ $product->sku ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                    Memiliki SKU
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Pergerakan Stok
                </h6>
            </div>
            <div class="card-body">
                @if($product->stockMovements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Stok Sebelum</th>
                                <th>Stok Sesudah</th>
                                <th>User</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->stockMovements->take(10) as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge {{ $movement->type === 'in' ? 'bg-success' : ($movement->type === 'out' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $movement->type === 'in' ? 'Masuk' : ($movement->type === 'out' ? 'Keluar' : 'Penyesuaian') }}
                                    </span>
                                </td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ $movement->stock_before }}</td>
                                <td>{{ $movement->stock_after }}</td>
                                <td>{{ $movement->user->name }}</td>
                                <td>{{ $movement->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada riwayat pergerakan stok</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Daftar Produk
            </a>
            <div>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Edit Produk
                </a>
                <form action="{{ route('products.toggle-status', $product) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" 
                            class="btn {{ $product->is_active ? 'btn-secondary' : 'btn-success' }}"
                            onclick="return confirm('Yakin ingin {{ $product->is_active ? 'menonaktifkan' : 'mengaktifkan' }} produk ini?')">
                        <i class="fas {{ $product->is_active ? 'fa-eye-slash' : 'fa-eye' }} me-2"></i>
                        {{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection






