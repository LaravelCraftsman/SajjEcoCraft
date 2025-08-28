@extends('layouts.app')

@section('title', 'Quotations')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ __('Quotations') }}
                        <a href="{{ route('quotations.create') }}" class="btn btn-primary btn-sm float-end">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Quotation Number</th>
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
                                @forelse ($allQuotations as $quotations)
                                    <tr id="quotations-row-{{ $quotations->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $quotations->quotation_number }}</td>
                                        <td>{{ $quotations->customer->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($quotations->quotations_date)->format('d-M-Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = match ($quotations->status) {
                                                    'paid' => 'badge bg-success',
                                                    'sent' => 'badge bg-info',
                                                    'draft' => 'badge bg-secondary',
                                                    'cancelled' => 'badge bg-danger',
                                                    default => 'badge bg-light',
                                                };
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ ucfirst($quotations->status) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $originalAmount = $quotations->total_amount;
                                                $finalAmount = $originalAmount;

                                                if (
                                                    $quotations->coupon_id &&
                                                    $quotations->coupon_value !== null &&
                                                    $quotations->coupon_type !== null
                                                ) {
                                                    $discountAmount =
                                                        $quotations->coupon_type === 'percentage'
                                                            ? ($originalAmount * $quotations->coupon_value) / 100
                                                            : $quotations->coupon_value;

                                                    $discountAmount = min($discountAmount, $originalAmount);
                                                    $finalAmount = $originalAmount - $discountAmount;
                                                }
                                            @endphp

                                            ₹<span id="original-amount-{{ $quotations->id }}">
                                                {{ number_format($finalAmount, 2) }}
                                            </span>

                                            @if ($quotations->coupon_id && $quotations->coupon_value !== null && $quotations->coupon_type !== null)
                                                <div class="text-success small mt-1"
                                                    id="discount-details-{{ $quotations->id }}">
                                                    Coupon Applied:
                                                    <strong>{{ $quotations->coupon->code ?? 'N/A' }}</strong><br>
                                                    Discount Type:
                                                    <strong>{{ ucfirst($quotations->coupon_type) }}</strong><br>
                                                    Discount Value:
                                                    @if ($quotations->coupon_type === 'percentage')
                                                        {{ $quotations->coupon_value }}%
                                                    @else
                                                        Rs. {{ number_format($quotations->coupon_value, 2) }}
                                                    @endif
                                                    <br>
                                                    Old Value: ₹{{ number_format($originalAmount, 2) }}<br>
                                                    Discount Amount: ₹{{ number_format($discountAmount, 2) }}<br>
                                                    Final Value (Subtotal): ₹{{ number_format($finalAmount, 2) }}
                                                </div>
                                            @else
                                                <div class="text-success small mt-1 d-none"
                                                    id="discount-details-{{ $quotations->id }}"></div>
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
                                                data-bs-target="#applyCouponModal-{{ $quotations->id }}">
                                                Coupon
                                            </button>
                                            <a target="_blank" href="{{ route('quotations.show', $quotations->id) }}"
                                                class="btn btn-sm btn-warning">PDF</a>
                                            <a href="{{ route('quotations.edit', $quotations->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('quotations.destroy', $quotations->id) }}"
                                                method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure to delete this quotations?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">No quotations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                        <div class="mt-3">
                            {{ $allQuotations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modals --}}
        @foreach ($allQuotations as $quotations)
            <div class="modal fade" id="applyCouponModal-{{ $quotations->id }}" tabindex="-1"
                aria-labelledby="applyCouponModalLabel-{{ $quotations->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="applyCouponModalLabel-{{ $quotations->id }}">
                                Apply Coupon to quotations #{{ $quotations->quotations_number }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="applyCouponForm-{{ $quotations->id }}">
                                <div class="mb-3">
                                    <label for="couponCode-{{ $quotations->id }}" class="form-label">Coupon Code</label>
                                    <input type="text" class="form-control" id="couponCode-{{ $quotations->id }}"
                                        name="coupon_code" placeholder="Enter coupon code">
                                    <div id="couponFeedback-{{ $quotations->id }}" class="small mt-1"></div>
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
            @foreach ($allQuotations as $quotations)
                (function() {
                    const quotationsId = {{ $quotations->id }};
                    const form = document.getElementById(`applyCouponForm-${quotationsId}`);
                    const input = document.getElementById(`couponCode-${quotationsId}`);
                    const feedback = document.getElementById(`couponFeedback-${quotationsId}`);
                    const modalEl = document.getElementById(`applyCouponModal-${quotationsId}`);
                    const originalAmountEl = document.getElementById(`original-amount-${quotationsId}`);
                    const discountDetailsEl = document.getElementById(`discount-details-${quotationsId}`);

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
                                `{{ route('coupons.validate.quotation') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        coupon_code: code,
                                        quotations_id: quotationsId
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
