@extends('layouts.app')
@section('title', 'Vendor')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Vendors List</span>
                        <a href="{{ route('vendors.create') }}" class="btn btn-sm btn-primary">Add Vendor</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        @if ($vendors->count())
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Company</th>
                                            <th>Created At</th>
                                            <th>Total Charges</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $vendor->name }}</td>
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phone }}</td>
                                                <td>{{ $vendor->company_name }}</td>
                                                <td>{{ $vendor->created_at->format('d M Y') }}</td>
                                                <td>{{ number_format($vendor->total_charges, 2) }}</td>
                                                <td>
                                                    <x-table-actions route="vendors" :id="$vendor->id" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No vendors found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
