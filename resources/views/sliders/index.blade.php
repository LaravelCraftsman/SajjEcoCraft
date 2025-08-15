@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h3>All Sliders</h3>
            <a href="{{ route('sliders.create') }}" class="btn btn-primary">+ Add New</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                @if ($sliders->count())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>CTA Label</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($slider->image)
                                            <img src="{{ asset($slider->image) }}" width="100">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->cta_label }}</td>
                                    <td>
                                        <span class="badge bg-{{ $slider->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($slider->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('sliders.edit', $slider->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No sliders found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
