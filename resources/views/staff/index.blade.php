@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Staff Users and Permissions

                        <a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm" style="float:right;">Create
                            Staff</a>

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
                                    <th>Create</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($staff as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{!! $user->create ? '✅' : '❌' !!}</td>
                                        <td>{!! $user->edit ? '✅' : '❌' !!}</td>
                                        <td>{!! $user->delete ? '✅' : '❌' !!}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('staff.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>

                                                <form action="{{ route('staff.destroy', $user->id) }}" method="post"
                                                    onsubmit="return confirm('Are you sure you want to delete this staff user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
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
