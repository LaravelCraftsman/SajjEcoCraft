@extends('layouts.app')
@section('title', 'Edit Vendor')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Edit Vendor</span>
                        <a href="{{ route('vendors.index') }}" class="btn btn-sm btn-secondary">Back</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Basic Info --}}
                                <div class="col-md-6 mb-3">
                                    <label for="name">Name *</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $vendor->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $vendor->email) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone">Phone *</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $vendor->phone) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="address">Address *</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $vendor->address) }}" required>
                                </div>

                                {{-- Company Info --}}
                                <div class="col-md-6 mb-3">
                                    <label for="company_name">Company Name *</label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ old('company_name', $vendor->company_name) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="company_website">Company Website</label>
                                    <input type="url" name="company_website" class="form-control"
                                        value="{{ old('company_website', $vendor->company_website) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gst">GST</label>
                                    <input type="text" name="gst" class="form-control"
                                        value="{{ old('gst', $vendor->gst) }}">
                                </div>

                                {{-- Bank Info --}}
                                <div class="col-md-6 mb-3">
                                    <label for="account_holder_name">Account Holder Name</label>
                                    <input type="text" name="account_holder_name" class="form-control"
                                        value="{{ old('account_holder_name', $vendor->account_holder_name) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control"
                                        value="{{ old('bank_name', $vendor->bank_name) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="account_number">Account Number</label>
                                    <input type="text" name="account_number" class="form-control"
                                        value="{{ old('account_number', $vendor->account_number) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ifsc_code">IFSC Code</label>
                                    <input type="text" name="ifsc_code" class="form-control"
                                        value="{{ old('ifsc_code', $vendor->ifsc_code) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="bank_address">Bank Address</label>
                                    <input type="text" name="bank_address" class="form-control"
                                        value="{{ old('bank_address', $vendor->bank_address) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="account_type">Account Type</label>
                                    <select name="account_type" class="form-control">
                                        <option value="current"
                                            {{ old('account_type', $vendor->account_type) == 'current' ? 'selected' : '' }}>
                                            Current</option>
                                        <option value="savings"
                                            {{ old('account_type', $vendor->account_type) == 'savings' ? 'selected' : '' }}>
                                            Savings</option>
                                    </select>
                                </div>

                                {{-- Charges & Profit --}}
                                <div class="col-md-6 mb-3">
                                    <label for="parking_charges">Parking Charges</label>
                                    <input type="text" name="parking_charges" class="form-control"
                                        value="{{ old('parking_charges', $vendor->parking_charges) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="operational_charges">Operational Charges</label>
                                    <input type="text" name="operational_charges" class="form-control"
                                        value="{{ old('operational_charges', $vendor->operational_charges) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="transport">Transport</label>
                                    <input type="text" name="transport" class="form-control"
                                        value="{{ old('transport', $vendor->transport) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dead_stock">Dead Stock</label>
                                    <input type="text" name="dead_stock" class="form-control"
                                        value="{{ old('dead_stock', $vendor->dead_stock) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="branding">Branding</label>
                                    <input type="text" name="branding" class="form-control"
                                        value="{{ old('branding', $vendor->branding) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="damage_and_shrinkege">Damage & Shrinkage</label>
                                    <input type="text" name="damage_and_shrinkege" class="form-control"
                                        value="{{ old('damage_and_shrinkege', $vendor->damage_and_shrinkege) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="profit">Profit</label>
                                    <input type="text" name="profit" class="form-control"
                                        value="{{ old('profit', $vendor->profit) }}">
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Update Vendor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
