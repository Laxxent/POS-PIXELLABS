@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Create New Purchase') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('purchases.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="supplier_id" class="col-md-4 col-form-label text-md-right">{{ __('Supplier') }}</label>
                            <div class="col-md-6">
                                <div class="supplier-dropdown">
                                    <select id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers ?? [] as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('supplier_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="payment_method" class="col-md-4 col-form-label text-md-right">{{ __('Payment Method') }}</label>
                            <div class="col-md-6">
                                <div class="payment-dropdown">
                                    <select id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                                    </select>
                                </div>
                                @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Purchase Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="purchase-items">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="product-dropdown">
                                                <select class="form-control product-select" name="items[0][product_id]" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($products ?? [] as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="items[0][quantity]" min="1" value="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control price" name="items[0][unit_price]" step="0.01" min="0" value="0" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control subtotal" name="items[0][subtotal]" step="0.01" min="0" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" class="btn btn-success btn-sm" id="add-item">Add Item</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="total_amount" class="col-md-4 col-form-label text-md-right">{{ __('Total Amount') }}</label>
                            <div class="col-md-6">
                                <input id="total_amount" type="number" class="form-control" name="total_amount" step="0.01" min="0" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="paid_amount" class="col-md-4 col-form-label text-md-right">{{ __('Paid Amount') }}</label>
                            <div class="col-md-6">
                                <input id="paid_amount" type="number" class="form-control @error('paid_amount') is-invalid @enderror" name="paid_amount" step="0.01" min="0" value="{{ old('paid_amount', 0) }}" required>
                                @error('paid_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>
                            <div class="col-md-6">
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Purchase') }}
                                </button>
                                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.product-dropdown, .supplier-dropdown, .payment-dropdown {
    position: relative;
}

.product-dropdown .form-control, .supplier-dropdown .form-control, .payment-dropdown .form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    padding-right: 2.5rem;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.product-dropdown .form-control:focus, .supplier-dropdown .form-control:focus, .payment-dropdown .form-control:focus {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23007bff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Dark mode support */
[data-theme="dark"] .product-dropdown .form-control, [data-theme="dark"] .supplier-dropdown .form-control, [data-theme="dark"] .payment-dropdown .form-control {
    background-color: #2d3748;
    border-color: #4a5568;
    color: #e9ecef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23e9ecef' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
}

[data-theme="dark"] .product-dropdown .form-control:focus, [data-theme="dark"] .supplier-dropdown .form-control:focus, [data-theme="dark"] .payment-dropdown .form-control:focus {
    background-color: #2d3748;
    border-color: #667eea;
    color: #e9ecef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
}

[data-theme="dark"] .product-dropdown .form-control option, [data-theme="dark"] .supplier-dropdown .form-control option, [data-theme="dark"] .payment-dropdown .form-control option {
    background-color: #2d3748;
    color: #e9ecef;
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Calculate subtotal when quantity or price changes
    $(document).on('input', '.quantity, .price', function() {
        calculateSubtotal($(this).closest('tr'));
        calculateTotal();
    });

    // Add new item row
    $('#add-item').click(function() {
        var rowCount = $('#purchase-items tbody tr').length;
        var newRow = $('#purchase-items tbody tr:first').clone();
        
        // Update name attributes with new index
        newRow.find('select[name*="[product_id]"]').attr('name', 'items[' + rowCount + '][product_id]');
        newRow.find('input[name*="[quantity]"]').attr('name', 'items[' + rowCount + '][quantity]');
        newRow.find('input[name*="[unit_price]"]').attr('name', 'items[' + rowCount + '][unit_price]');
        newRow.find('input[name*="[subtotal]"]').attr('name', 'items[' + rowCount + '][subtotal]');
        
        // Clear values
        newRow.find('input').val('');
        newRow.find('select').val('');
        newRow.find('.quantity').val(1);
        newRow.find('.subtotal').val('');
        
        $('#purchase-items tbody').append(newRow);
    });

    // Remove item row
    $(document).on('click', '.remove-item', function() {
        if ($('#purchase-items tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateTotal();
        } else {
            alert('At least one item is required.');
        }
    });

    // Set price when product is selected
    $(document).on('change', '.product-select', function() {
        var price = $(this).find(':selected').data('price') || 0;
        $(this).closest('tr').find('.price').val(price);
        calculateSubtotal($(this).closest('tr'));
        calculateTotal();
    });

    // Calculate subtotal for a row
    function calculateSubtotal(row) {
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var subtotal = quantity * price;
        row.find('.subtotal').val(subtotal.toFixed(2));
    }

    // Calculate total amount
    function calculateTotal() {
        var total = 0;
        $('.subtotal').each(function() {
            var subtotalValue = parseFloat($(this).val()) || 0;
            total += subtotalValue;
        });
        $('#total_amount').val(total.toFixed(2));
        
        // Auto-update paid amount to match total amount
        $('#paid_amount').val(total.toFixed(2));
    }

    // Format number with thousand separators
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Initialize calculation on page load
    calculateTotal();
});
</script>
@endpush