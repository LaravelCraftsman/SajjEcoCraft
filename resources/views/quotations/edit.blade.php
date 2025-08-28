@extends('layouts.app')

@section('title')
    Edit Quotation
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">
                        Edit Quotation
                        <a href="{{ route('quotations.index') }}" class="btn btn-secondary btn-sm"
                            style="float: right;">Back</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('quotations.update', $quotation->id) }}" method="POST" id="quotationForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer <span
                                        class="text-danger">*</span></label>
                                <select name="customer_id" id="customer_id"
                                    class="form-select @error('customer_id') is-invalid @enderror" required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id', $quotation->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="quotation_number" class="form-label">Quotation Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="quotation_number" id="quotation_number"
                                        class="form-control @error('quotation_number') is-invalid @enderror"
                                        value="{{ old('quotation_number', $quotation->quotation_number) }}" required>
                                    @error('quotation_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="quotation_date" class="form-label">Quotation Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="quotation_date" id="quotation_date"
                                        class="form-control @error('quotation_date') is-invalid @enderror"
                                        value="{{ old('quotation_date', $quotation->quotation_date->format('Y-m-d')) }}"
                                        required>
                                    @error('quotation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    @foreach (['draft', 'sent', 'paid', 'cancelled'] as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', $quotation->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $quotation->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <h5>Products</h5>
                            <table class="table table-bordered" id="productsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Product <span class="text-danger">*</span></th>
                                        <th style="width: 20%;">Quantity <span class="text-danger">*</span></th>
                                        <th style="width: 20%;">Rate <span class="text-danger">*</span></th>
                                        <th style="width: 15%;">Amount</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (old('products'))
                                        @foreach (old('products') as $index => $prod)
                                            <tr>
                                                <td>
                                                    <select name="products[{{ $index }}][product_id]"
                                                        class="form-select product-select" required>
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $prod['product_id'] == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $index }}][quantity]"
                                                        min="0.01" step="0.01" class="form-control quantity"
                                                        value="{{ $prod['quantity'] }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $index }}][rate]"
                                                        min="0" step="0.01" class="form-control rate"
                                                        value="{{ $prod['rate'] }}" required>
                                                </td>
                                                <td class="amount-cell">
                                                    ${{ number_format($prod['quantity'] * $prod['rate'], 2) }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row">&times;</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @elseif ($quotation->products && $quotation->products->count())
                                        @foreach ($quotation->products as $index => $item)
                                            <tr>
                                                <td>
                                                    <select name="products[{{ $index }}][product_id]"
                                                        class="form-select product-select" required>
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $index }}][quantity]"
                                                        min="0.01" step="0.01" class="form-control quantity"
                                                        value="{{ $item->quantity }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $index }}][rate]"
                                                        min="0" step="0.01" class="form-control rate"
                                                        value="{{ $item->rate }}" required>
                                                </td>
                                                <td class="amount-cell">
                                                    ${{ number_format($item->quantity * $item->rate, 2) }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row">&times;</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                <select name="products[0][product_id]" class="form-select product-select"
                                                    required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][quantity]" min="0.01"
                                                    step="0.01" class="form-control quantity" value="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][rate]" min="0"
                                                    step="0.01" class="form-control rate" value="0.00" required>
                                            </td>
                                            <td class="amount-cell">$0.00</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-row">&times;</button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td id="totalAmount" class="fw-bold">
                                            ${{ number_format($quotation->total_amount, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <button type="button" class="btn btn-outline-primary btn-sm" id="addProductBtn">+ Add
                                Product</button>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">Update Quotation</button>
                                <a href="{{ route('quotations.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- Script for dynamic product rows and calculating totals --}}
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // Generate quotation number dynamically
            const quotationInput = document.getElementById('quotation_number');
            if (quotationInput && !quotationInput.value) {
                const timestamp = Date.now().toString();
                const last6 = timestamp.slice(-6);
                quotationInput.value = `QUOTE${last6}SEC`;
            }
            // Product data map: productId => {selling_price, discount}
            const productsData = {
                @foreach ($products as $product)
                    {{ $product->id }}: {
                        selling_price: parseFloat('{{ $product->selling_price }}'),
                        discount: parseFloat('{{ $product->discount ?? 0 }}')
                    },
                @endforeach
            };

            function recalcRowAmount(row) {
                const qty = parseFloat(row.querySelector('.quantity').value) || 0;
                const rateInput = row.querySelector('.rate');
                const rate = parseFloat(rateInput.value) || 0;
                const amountCell = row.querySelector('.amount-cell');
                const amount = qty * rate;
                amountCell.textContent = `₹${amount.toFixed(2)}`;
                return amount;
            }

            function recalcTotal() {
                let total = 0;
                document.querySelectorAll('#productsTable tbody tr').forEach(row => {
                    total += recalcRowAmount(row);
                });
                document.getElementById('totalAmount').textContent = `₹${total.toFixed(2)}`;
            }

            function updateIndices() {
                document.querySelectorAll('#productsTable tbody tr').forEach((row, index) => {
                    row.querySelectorAll('select, input').forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            const newName = name.replace(/\d+/, index);
                            input.setAttribute('name', newName);
                        }
                    });
                });
            }

            // On product select change: update rate based on discount & selling price
            function onProductChange(event) {
                const select = event.target;
                const row = select.closest('tr');
                const productId = select.value;

                if (productsData[productId]) {
                    const sellingPrice = productsData[productId].selling_price;
                    const discount = productsData[productId].discount;

                    let newRate = sellingPrice;
                    if (discount > 0) {
                        newRate = sellingPrice - discount;
                        if (newRate < 0) newRate = 0; // don't allow negative price
                    }

                    const rateInput = row.querySelector('.rate');
                    rateInput.value = newRate.toFixed(2);
                } else {
                    // No product selected or product data missing
                    const rateInput = row.querySelector('.rate');
                    rateInput.value = '0.00';
                }

                recalcTotal();
            }

            recalcTotal();

            document.getElementById('addProductBtn').addEventListener('click', function() {
                const tbody = document.querySelector('#productsTable tbody');
                const newIndex = tbody.querySelectorAll('tr').length;
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                <td>
                    <select name="products[${newIndex}][product_id]" class="form-select product-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${newIndex}][quantity]" min="0.01" step="0.01" class="form-control quantity" value="1" required>
                </td>
                <td>
                    <input type="number" name="products[${newIndex}][rate]" min="0" step="0.01" class="form-control rate" value="0.00" required>
                </td>
                <td class="amount-cell">$0.00</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
                </td>
            `;

                tbody.appendChild(newRow);

                // Attach change event for new product select
                newRow.querySelector('.product-select').addEventListener('change', onProductChange);

                recalcTotal();
            });

            // Attach existing product select change event listeners
            document.querySelectorAll('.product-select').forEach(select => {
                select.addEventListener('change', onProductChange);
            });

            document.querySelector('#productsTable tbody').addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('rate')) {
                    recalcTotal();
                }
            });

            document.querySelector('#productsTable tbody').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    if (confirm('Remove this product?')) {
                        e.target.closest('tr').remove();
                        updateIndices();
                        recalcTotal();
                    }
                }
            });
        });
    </script>
@endsection
