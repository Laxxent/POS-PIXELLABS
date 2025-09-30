@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Sale') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('sales.update', $sale->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="customer_id" class="col-md-4 col-form-label text-md-right">{{ __('Customer') }}</label>
                            <div class="col-md-6">
                                <select id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers ?? [] as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date', $sale->date) }}" required>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="reference" class="col-md-4 col-form-label text-md-right">{{ __('Reference No') }}</label>
                            <div class="col-md-6">
                                <input id="reference" type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" value="{{ old('reference', $sale->reference) }}" required>
                                @error('reference')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Sale Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="sale-items">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->items as $index => $item)
                                    <tr>
                                        <td>
                                            <select class="form-control product-select" name="products[]" required>
                                                <option value="">Select Product</option>
                                                @foreach($products ?? [] as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="quantities[]" min="1" value="{{ $item->quantity }}" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control price" name="prices[]" step="0.01" min="0" value="{{ $item->price }}" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control subtotal" name="subtotals[]" step="0.01" min="0" value="{{ $item->subtotal }}" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                                        </td>
                                    </tr>
                                    @endforeach
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
                                <input id="total_amount" type="number" class="form-control" name="total_amount" step="0.01" min="0" value="{{ $sale->total_amount }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="payment_method" class="col-md-4 col-form-label text-md-right">{{ __('Payment Method') }}</label>
                            <div class="col-md-6">
                                <select id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                    <option value="cash" {{ old('payment_method', $sale->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="card" {{ old('payment_method', $sale->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="transfer" {{ old('payment_method', $sale->payment_method) == 'transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>
                            <div class="col-md-6">
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes">{{ old('notes', $sale->notes) }}</textarea>
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
                                    {{ __('Update Sale') }}
                                </button>
                                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Calculate subtotal when quantity or price changes
        $(document).on('input', '.quantity, .price', function() {
            calculateSubtotal($(this).closest('tr'));
            calculateTotal();
        });

        // Add new item row
        $('#add-item').click(function() {
            var newRow = $('#sale-items tbody tr:first').clone();
            newRow.find('input').val('');
            newRow.find('select').val('');
            newRow.find('.quantity').val(1);
            $('#sale-items tbody').append(newRow);
        });

        // Remove item row
        $(document).on('click', '.remove-item', function() {
            if ($('#sale-items tbody tr').length > 1) {
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
                total += parseFloat($(this).val()) || 0;
            });
            $('#total_amount').val(total.toFixed(2));
        }

        // Initialize calculations
        $('#sale-items tbody tr').each(function() {
            calculateSubtotal($(this));
        });
        calculateTotal();
    });
</script>
@endsection