@extends('layouts.app')

@section('title', 'Create Blog')

@section('head')
    {{-- CKEditor CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Create New Blog</div>

                    <div class="card-body">
                        @include('partials.alerts') {{-- your alert partial for errors/success --}}

                        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Title --}}
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Main Image --}}
                            <div class="mb-3">
                                <label for="main_image" class="form-label">Main Image <span
                                        class="text-danger">*</span></label>
                                <input type="file" id="main_image" name="main_image"
                                    class="form-control @error('main_image') is-invalid @enderror" accept="image/*"
                                    required>
                                @error('main_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Content --}}
                            <div class="mb-3">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror"
                                    required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" class="btn btn-primary">Create Blog</button>
                            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection




@section('scripts')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('blogs.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            on: {
                'instanceReady': function(ev) {
                    // Hide the version warning by setting the display of the warning box to none
                    var warningBox = ev.editor.container.getChild(0);
                    if (warningBox && warningBox.getChildCount() > 0) {
                        warningBox.getChild(0).setStyle('display', 'none');
                    }
                }
            }
        });
    </script>
@endsection
