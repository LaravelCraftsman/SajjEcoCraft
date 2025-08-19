@extends('layouts.app')

@section('title', 'Branches')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Branches List</h4>
                        <a href="{{ route('branches.create') }}" class="btn btn-primary btn-sm">Add New Branch</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        @if ($branches->count())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 5%;">Sr. No</th>
                                            <th style="width: 20%;">Title</th>
                                            <th style="width: 15%;">Address</th> <!-- Reduced -->
                                            <th style="width: 20%;">Email Address</th>
                                            <th style="width: 15%;">Phone Number</th>
                                            <th style="width: 15%;">Created At</th>
                                            <th style="width: 10%;">Actions</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($branches as $branch)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $branch->title }}</td>
                                                <td>
                                                    {{ $branch->address }}</td>
                                                <td>{{ $branch->email_address }}</td>
                                                <td>{{ $branch->phone_number }}</td>
                                                <td>{{ $branch->created_at->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('branches.edit', $branch->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>

                                                        <form action="{{ route('branches.destroy', $branch->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        @else
                            <p class="text-center">No branches found.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
