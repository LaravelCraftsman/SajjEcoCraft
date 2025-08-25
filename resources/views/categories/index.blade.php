@extends('layouts.app')

@section('title', 'Categories')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Categories</span>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">Add New Category</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        @if ($categories->count())
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->created_at->format('d M Y') }}</td>
                                            {{-- <td>
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('categories.destroy', $category->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                            </td> --}}

                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <x-table-actions route="categories" :id="$category->id" />
                                                    <a target="_blank" href="{{ route('categories.pdf', $category->id) }}"
                                                        class="btn btn-warning btn-sm">PDF</a>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $categories->links() }}
                        @else
                            <div class="alert alert-info">No categories found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
