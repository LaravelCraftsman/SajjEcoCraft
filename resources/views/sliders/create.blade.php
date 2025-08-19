@extends('layouts.app')

@section('title', 'Add Slider')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Add New Slider</div>

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

                        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', 'SajjEcoCraft') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', 'SajjEcoCraft') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tag</label>
                                <input type="text" name="tag" class="form-control"
                                    value="{{ old('tag', 'SajjEcoCraft') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CTA Label</label>
                                <input type="text" name="cta_label" class="form-control"
                                    value="{{ old('cta_label', 'SajjEcoCraft') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CTA URL</label>
                                <input type="url" name="cta_url" class="form-control"
                                    value="{{ old('cta_url', 'https://www.google.com') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image (JPG/PNG/GIF, max 2MB)</label>
                                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Create Slider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
