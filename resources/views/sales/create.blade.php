@extends('layouts.app')

@section('title', 'Tambah Penjualan - POS Application')
@section('page-title', 'Tambah Penjualan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-plus me-2"></i>
                    Form Penjualan Baru
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                    @csrf
                    
                    <!-- Hidden field for sale type -->
                    <input type="hidden" name="type" value="retail">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <div class="customer-dropdown">
                                    <select id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                                        <option value="">Pelanggan Umum</option>
                                        @foreach($customers ?? [] as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="reference" class="form-label">No. Referensi</label>
                                <input id="reference" type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" value="{{ old('reference', '1') }}" required>
                                @error('reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3">Item Penjualan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="sale-items">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                                <tr class="item-row">
                                    <td>
                                        <div class="product-dropdown">
                                            <select class="form-control product-select" name="items[0][product_id]" required>
                                                <option value="">Pilih Produk</option>
                                                @foreach($products ?? [] as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price ?? $product->selling_price }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="items[0][quantity]" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control price" name="items[0][unit_price]" step="0.01" min="0" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control subtotal" name="items[0][subtotal]" step="0.01" min="0" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-item">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-success btn-sm" id="add-item">
                                            <i class="fas fa-plus me-1"></i> Tambah Item
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_amount" class="form-label">Jumlah Bayar</label>
                                <input id="total_amount" type="number" class="form-control" name="paid_amount" step="0.01" min="0" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                <div class="payment-dropdown">
                                    <select id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                        <option value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                                    </select>
                                </div>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Penjualan
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Custom dropdown arrows */
.customer-dropdown,
.product-dropdown,
.payment-dropdown {
    position: relative;
}

.customer-dropdown select,
.product-dropdown select,
.payment-dropdown select {
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
}

/* Dark mode support */
[data-bs-theme="dark"] .customer-dropdown select,
[data-bs-theme="dark"] .product-dropdown select,
[data-bs-theme="dark"] .payment-dropdown select {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-color: #343a40;
}

/* Hover effects */
.customer-dropdown select:hover,
.product-dropdown select:hover,
.payment-dropdown select:hover {
    border-color: #007bff;
}

/* Focus effects */
.customer-dropdown select:focus,
.product-dropdown select:focus,
.payment-dropdown select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Additional browser-specific fixes */
.customer-dropdown select::-ms-expand,
.product-dropdown select::-ms-expand,
.payment-dropdown select::-ms-expand {
    display: none;
}

.customer-dropdown select::-webkit-outer-spin-button,
.customer-dropdown select::-webkit-inner-spin-button,
.product-dropdown select::-webkit-outer-spin-button,
.product-dropdown select::-webkit-inner-spin-button,
.payment-dropdown select::-webkit-outer-spin-button,
.payment-dropdown select::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // Calculate subtotal when quantity or price changes
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
            calculateSubtotal(e.target.closest('tr'));
            calculateTotal();
        }
    });

    // Add new item row
    document.getElementById('add-item').addEventListener('click', function() {
        const tbody = document.getElementById('items-tbody');
        const firstRow = tbody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);
        
        // Update input names with new index
        newRow.querySelectorAll('input, select').forEach(function(input) {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, '[' + itemIndex + ']'));
            }
        });
        
        // Clear values
        newRow.querySelectorAll('input').forEach(function(input) {
            if (input.type === 'number') {
                input.value = input.classList.contains('quantity') ? '1' : '';
            }
        });
        newRow.querySelector('select').value = '';
        
        // Ensure the new row has the product dropdown wrapper
        const selectCell = newRow.querySelector('td:first-child');
        const select = selectCell.querySelector('select');
        if (select && !selectCell.querySelector('.product-dropdown')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'product-dropdown';
            selectCell.insertBefore(wrapper, select);
            wrapper.appendChild(select);
        }
        
        tbody.appendChild(newRow);
        itemIndex++;
    });

    // Remove item row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            const tbody = document.getElementById('items-tbody');
            const rows = tbody.querySelectorAll('tr');
            
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculateTotal();
            } else {
                alert('Minimal satu item diperlukan.');
            }
        }
    });

    // Set price when product is selected
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            const row = e.target.closest('tr');
            const priceInput = row.querySelector('.price');
            
            priceInput.value = price;
            calculateSubtotal(row);
            calculateTotal();
        }
    });

    // Calculate subtotal for a row
    function calculateSubtotal(row) {
        const quantityInput = row.querySelector('.quantity');
        const priceInput = row.querySelector('.price');
        const subtotalInput = row.querySelector('.subtotal');
        
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const subtotal = quantity * price;
        
        subtotalInput.value = subtotal.toFixed(2);
    }

    // Calculate total amount
    function calculateTotal() {
        const subtotalInputs = document.querySelectorAll('.subtotal');
        let total = 0;
        
        subtotalInputs.forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        
        document.getElementById('total_amount').value = total.toFixed(2);
    }
});
</script>