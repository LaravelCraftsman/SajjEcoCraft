@extends('layouts.app')

@section('title', 'Edit Slider')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Edit Slider</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Please fix the following issues:<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $slider->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $slider->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tag</label>
                                <input type="text" name="tag" class="form-control"
                                    value="{{ old('tag', $slider->tag) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CTA Label</label>
                                <input type="text" name="cta_label" class="form-control"
                                    value="{{ old('cta_label', $slider->cta_label) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CTA URL</label>
                                <input type="url" name="cta_url" class="form-control"
                                    value="{{ old('cta_url', $slider->cta_url) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Image</label><br>
                                @if ($slider->image)
                                    <img src="{{ $slider->image }}" alt="Slider Image" style="max-width: 200px;"
                                        class="mb-2">
                                @else
                                    <p>No image uploaded.</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Change Image (optional)</label>
                                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $slider->status === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $slider->status === 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update Slider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
