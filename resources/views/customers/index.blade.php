@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Customers

                        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm" style="float:right;">Create
                            Customer</a>

                        <a href="{{ route('customers.export') }}" class="btn btn-success btn-sm"
                            style="float:right; margin-right: 10px;">
                            Export Customers
                        </a>


                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <table class="table table-bordered text-center table-stripped table-responsive">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <x-table-actions route="customers" :id="$user->id" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No staff users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
