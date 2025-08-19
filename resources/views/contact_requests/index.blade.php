@extends('layouts.app')

@section('title', 'Contact Requests')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Contact Requests') }}
                        <!-- Button to create new contact request -->
                        <a href="{{ route('contactRequests.create') }}" class="btn btn-primary btn-sm"
                            style="float: right;">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts') <!-- Success or error messages -->

                        <!-- Table displaying the contact requests -->
                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">Sr. No.</th>
                                    <th scope="col" width="15%">Name</th>
                                    <th scope="col" width="20%">Email</th>
                                    <th scope="col" width="15%">Phone</th>
                                    <th scope="col" width="30%">Message</th>
                                    <th scope="col" width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactRequests as $contactRequest)
                                    <tr>
                                        <!-- Sr. No. Column -->
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $contactRequest->name }}</td>
                                        <td>{{ $contactRequest->email }}</td>
                                        <td>{{ $contactRequest->phone }}</td>
                                        <td>{{ Str::limit($contactRequest->message, 50) }}</td>
                                        <td><x-table-actions route="contactRequests" :id="$contactRequest->id" /></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        {{ $contactRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
