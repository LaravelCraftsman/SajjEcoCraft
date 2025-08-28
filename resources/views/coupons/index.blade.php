@extends('layouts.app')

@section('title', 'Coupons')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Coupons</h4>
                <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-sm">Add Coupon</a>
            </div>
            <div class="card-body">
                @include('partials.alerts')
                @if ($coupons->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:5%;">Sr. No</th>
                                    <th style="width:20%;">Code</th>
                                    <th style="width:15%;">Type</th>
                                    <th style="width:15%;">Discount</th>
                                    <th style="width:20%;">Expires At</th>
                                    <th style="width:15%;">Usage</th>
                                    <th style="width:10%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->iteration + ($coupons->currentPage() - 1) * $coupons->perPage() }}
                                        </td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ ucfirst($coupon->type) }}</td>
                                        <td>{{ $coupon->discount }}{{ $coupon->type === 'percentage' ? '%' : '' }}</td>
                                        <td>{{ optional($coupon->expires_at)->format('d M Y') ?? '-' }}</td>
                                        <td>{{ $coupon->times_used }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                                        <td><x-table-actions route="coupons" :id="$coupon->id" /></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $coupons->links() }}</div>
                @else
                    <p class="text-center">No coupons found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
