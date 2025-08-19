@extends('layouts.app')

@section('title', 'Sliders')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Sliders</h5>
                        <a href="{{ route('sliders.create') }}" class="btn btn-sm btn-primary">Add Slider</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if ($sliders->count())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Tag</th>
                                            <th>CTA</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sliders as $index => $slider)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($slider->image)
                                                        <a href="{{ $slider->image }}" target="_blank"> <img
                                                                src="{{ $slider->image }}" alt="Slider Image" width="80"
                                                                height="60" style="object-fit: cover;"></a>
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $slider->title }}</td>
                                                <td>{{ $slider->tag }}</td>
                                                <td>
                                                    <a href="{{ $slider->cta_url }}" target="_blank">
                                                        {{ $slider->cta_label }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $slider->status === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($slider->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $slider->created_at->format('d-M-Y h:i A') }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('sliders.edit', $slider->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>

                                                        <form action="{{ route('sliders.destroy', $slider->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                No sliders found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
