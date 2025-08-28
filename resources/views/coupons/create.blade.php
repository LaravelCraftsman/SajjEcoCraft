@extends('layouts.app')

@section('title', 'Create Coupon')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Create Coupon</div>
            <div class="card-body">
                @include('partials.alerts')
                <form action="{{ route('coupons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}"
                            class="form-control @error('code') is-invalid @enderror" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>percentage
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Discount <span class="text-danger">*</span></label>
                        <input type="number" name="discount" min="0" step="0.01" value="{{ old('discount') }}"
                            class="form-control @error('discount') is-invalid @enderror" required>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expires At</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                            class="form-control @error('expires_at') is-invalid @enderror">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" min="1" value="{{ old('usage_limit') }}"
                            class="form-control @error('usage_limit') is-invalid @enderror">
                        @error('usage_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave blank for unlimited usage.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
