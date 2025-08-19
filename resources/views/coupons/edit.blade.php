@extends('layouts.app')

@section('title', 'Edit Coupon')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Coupon</div>
            <div class="card-body">
                @include('partials.alerts')
                <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code) }}"
                            class="form-control @error('code') is-invalid @enderror" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Percent
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Discount <span class="text-danger">*</span></label>
                        <input type="number" name="discount" min="0" step="0.01"
                            value="{{ old('discount', $coupon->discount) }}"
                            class="form-control @error('discount') is-invalid @enderror" required>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expires At</label>
                        <input type="date" name="expires_at"
                            value="{{ old('expires_at', optional($coupon->expires_at)->format('Y-m-d')) }}"
                            class="form-control @error('expires_at') is-invalid @enderror">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" min="1"
                            value="{{ old('usage_limit', $coupon->usage_limit) }}"
                            class="form-control @error('usage_limit') is-invalid @enderror">
                        @error('usage_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
