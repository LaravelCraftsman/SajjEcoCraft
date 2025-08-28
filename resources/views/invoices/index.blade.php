@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ __('Invoices') }}
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm float-end">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Invoice Number</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Subtotal</th>
                                    <th>GST (18%)</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr id="invoice-row-{{ $invoice->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = match ($invoice->status) {
                                                    'paid' => 'badge bg-success',
                                                    'sent' => 'badge bg-info',
                                                    'draft' => 'badge bg-secondary',
                                                    'cancelled' => 'badge bg-danger',
                                                    default => 'badge bg-light',
                                                };
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ ucfirst($invoice->status) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $originalAmount = $invoice->total_amount;
                                                $finalAmount = $originalAmount;

                                                if (
                                                    $invoice->coupon_id &&
                                                    $invoice->coupon_value !== null &&
                                                    $invoice->coupon_type !== null
                                                ) {
                                                    $discountAmount =
                                                        $invoice->coupon_type === 'percentage'
                                                            ? ($originalAmount * $invoice->coupon_value) / 100
                                                            : $invoice->coupon_value;

                                                    $discountAmount = min($discountAmount, $originalAmount);
                                                    $finalAmount = $originalAmount - $discountAmount;
                                                }
                                            @endphp

                                            ₹<span id="original-amount-{{ $invoice->id }}">
                                                {{ number_format($finalAmount, 2) }}
                                            </span>

                                            @if ($invoice->coupon_id && $invoice->coupon_value !== null && $invoice->coupon_type !== null)
                                                <div class="text-success small mt-1"
                                                    id="discount-details-{{ $invoice->id }}">
                                                    Coupon Applied:
                                                    <strong>{{ $invoice->coupon->code ?? 'N/A' }}</strong><br>
                                                    Discount Type:
                                                    <strong>{{ ucfirst($invoice->coupon_type) }}</strong><br>
                                                    Discount Value:
                                                    @if ($invoice->coupon_type === 'percentage')
                                                        {{ $invoice->coupon_value }}%
                                                    @else
                                                        Rs. {{ number_format($invoice->coupon_value, 2) }}
                                                    @endif
                                                    <br>
                                                    Old Value: ₹{{ number_format($originalAmount, 2) }}<br>
                                                    Discount Amount: ₹{{ number_format($discountAmount, 2) }}<br>
                                                    Final Value (Subtotal): ₹{{ number_format($finalAmount, 2) }}
                                                </div>
                                            @else
                                                <div class="text-success small mt-1 d-none"
                                                    id="discount-details-{{ $invoice->id }}"></div>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $gst = $finalAmount * 0.18;
                                            @endphp
                                            ₹{{ number_format($gst, 2) }}
                                        </td>
                                        <td>
                                            @php
                                                $total = $finalAmount + $gst;
                                            @endphp
                                            ₹{{ number_format($total, 2) }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#applyCouponModal-{{ $invoice->id }}">
                                                Coupon
                                            </button>
                                            <a target="_blank" href="{{ route('invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-warning">PDF</a>
                                            <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure to delete this invoice?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">No invoices found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                        <div class="mt-3">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modals --}}
        @foreach ($invoices as $invoice)
            <div class="modal fade" id="applyCouponModal-{{ $invoice->id }}" tabindex="-1"
                aria-labelledby="applyCouponModalLabel-{{ $invoice->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="applyCouponModalLabel-{{ $invoice->id }}">
                                Apply Coupon to Invoice #{{ $invoice->invoice_number }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="applyCouponForm-{{ $invoice->id }}">
                                <div class="mb-3">
                                    <label for="couponCode-{{ $invoice->id }}" class="form-label">Coupon Code</label>
                                    <input type="text" class="form-control" id="couponCode-{{ $invoice->id }}"
                                        name="coupon_code" placeholder="Enter coupon code">
                                    <div id="couponFeedback-{{ $invoice->id }}" class="small mt-1"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Apply Coupon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($invoices as $invoice)
                (function() {
                    const invoiceId = {{ $invoice->id }};
                    const form = document.getElementById(`applyCouponForm-${invoiceId}`);
                    const input = document.getElementById(`couponCode-${invoiceId}`);
                    const feedback = document.getElementById(`couponFeedback-${invoiceId}`);
                    const modalEl = document.getElementById(`applyCouponModal-${invoiceId}`);
                    const originalAmountEl = document.getElementById(`original-amount-${invoiceId}`);
                    const discountDetailsEl = document.getElementById(`discount-details-${invoiceId}`);

                    if (!originalAmountEl) return;

                    const originalAmount = parseFloat(originalAmountEl.textContent.replace(/[^0-9.]/g, ''));

                    input.addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                        feedback.textContent = '';
                        feedback.classList.remove('text-success', 'text-danger');
                    });

                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const code = input.value.trim();

                        if (!code) return;

                        try {
                            const response = await fetch(
                            `{{ route('coupons.validate.invoice') }}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    coupon_code: code,
                                    invoice_id: invoiceId
                                }),
                            });

                            const result = await response.json();
                            console.log('Coupon validation response:', result);
                            // alert(result);

                            if (result.valid) {
                                feedback.textContent = result.message;
                                feedback.classList.remove('text-danger');
                                feedback.classList.add('text-success');

                                let discount = result.discount_type === 'percentage' ?
                                    (originalAmount * result.discount_value) / 100 :
                                    parseFloat(result.discount_value);

                                discount = Math.min(discount, originalAmount);
                                let finalAmount = (originalAmount - discount).toFixed(2);

                                if (discountDetailsEl) {
                                    discountDetailsEl.style.display = 'block';
                                    discountDetailsEl.classList.remove('d-none');
                                    discountDetailsEl.innerHTML = `
                                    <span>-₹${discount.toFixed(2)} discount</span><br>
                                    <strong>Final: ₹${finalAmount}</strong>
                                `;
                                }

                                setTimeout(() => {
                                    const modal = bootstrap.Modal.getInstance(modalEl);
                                    modal.hide();
                                    location
                                        .reload(); // optional: remove if updating via AJAX
                                }, 1000);
                            } else {
                                feedback.textContent = result.message;
                                feedback.classList.remove('text-success');
                                feedback.classList.add('text-danger');
                            }
                        } catch (error) {
                            feedback.textContent = 'Server error validating coupon.';
                            feedback.classList.add('text-danger');
                            console.error(error);
                        }
                    });

                    modalEl.addEventListener('hidden.bs.modal', function() {
                        input.value = '';
                        feedback.textContent = '';
                        feedback.classList.remove('text-success', 'text-danger');
                    });
                })();
            @endforeach
        });
    </script>
@endsection
