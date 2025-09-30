@extends('layouts.app')

@section('title', 'Manajemen Produk - POS Application')
@section('page-title', 'Manajemen Produk')

@push('styles')
<style>
/* Product Filter Dropdown Styling */
.product-filter-dropdown {
    min-width: 150px;
    flex-shrink: 0;
}

.product-filter-dropdown select {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    -ms-appearance: none !important;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 40px;
    background-color: white;
    border: 1px solid #ced4da;
    width: 100%;
    min-width: 150px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Dark mode support for product filter dropdown */
[data-bs-theme="dark"] .product-filter-dropdown select {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-color: #343a40;
    border-color: #6c757d;
    color: #ffffff;
}

/* Aggressive browser-specific fixes to remove default arrows */
.product-filter-dropdown select::-ms-expand {
    display: none !important;
}

.product-filter-dropdown select::-webkit-outer-spin-button,
.product-filter-dropdown select::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important;
}

/* Additional fixes for different browsers */
.product-filter-dropdown select::-moz-appearance {
    -moz-appearance: none !important;
}

.product-filter-dropdown select::-o-appearance {
    -o-appearance: none !important;
}

/* Force remove any default styling */
.product-filter-dropdown select {
    -webkit-border-radius: 0 !important;
    -moz-border-radius: 0 !important;
    border-radius: 0.375rem !important;
    outline: none !important;
}

/* Ensure no default dropdown arrow appears */
.product-filter-dropdown select option {
    background-color: white;
    color: #212529;
}

[data-bs-theme="dark"] .product-filter-dropdown select option {
    background-color: #343a40;
    color: #ffffff;
}

/* Form filter layout improvements */
.d-flex {
    flex-wrap: nowrap;
    align-items: center;
    gap: 0.5rem;
}

.form-control {
    flex-shrink: 1;
}

/* Responsive design for filter form */
@media (max-width: 768px) {
    .product-filter-dropdown {
        min-width: 120px;
    }
    
    .product-filter-dropdown select {
        min-width: 120px;
        font-size: 0.875rem;
    }
    
    .form-control {
        min-width: 150px !important;
    }
}

@media (max-width: 576px) {
    .d-flex {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .product-filter-dropdown {
        min-width: 100%;
    }
    
    .product-filter-dropdown select {
        min-width: 100%;
    }
    
    .form-control {
        min-width: 100% !important;
    }
}
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Produk
        </a>
    </div>
    <div class="col-md-6">
        <form method="GET" action="{{ route('products.index') }}" class="d-flex">
            <input type="text" 
                   name="search" 
                   class="form-control me-2" 
                   placeholder="Cari produk..." 
                   value="{{ request('search') }}"
                   style="min-width: 200px;">
            <div class="product-filter-dropdown me-2">
                <select name="category_id" class="form-select" style="min-width: 180px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="product-filter-dropdown me-2">
                <select name="stock_status" class="form-select" style="min-width: 150px;">
                    <option value="">Semua Stok</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Stok Habis</option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-box me-2"></i>
            Daftar Produk
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Barcode</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>
                            @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="rounded" 
                                     width="50" 
                                     height="50"
                                     style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-box text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $product->code ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($product->sku)
                                <br><small class="text-muted">SKU: {{ $product->sku }}</small>
                            @endif
                        </td>
                        <td>
                            @if($product->barcode)
                                <code>{{ $product->barcode }}</code>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->formatted_price }}</td>
                        <td>
                            <span class="badge {{ $product->isLowStock() ? 'bg-warning' : 'bg-success' }}">
                                {{ $product->stock }} {{ $product->unit->symbol }}
                            </span>
                            @if($product->isLowStock())
                                <br><small class="text-warning">Stok Rendah!</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.toggle-status', $product) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm {{ $product->is_active ? 'btn-secondary' : 'btn-success' }}" 
                                            title="{{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                            onclick="return confirm('Yakin ingin {{ $product->is_active ? 'menonaktifkan' : 'mengaktifkan' }} produk ini?')">
                                        <i class="fas {{ $product->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('products.destroy', $product) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="py-4">
                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada produk ditemukan</p>
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Tambah Produk Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection






