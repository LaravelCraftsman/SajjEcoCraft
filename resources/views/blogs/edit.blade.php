@extends('layouts.app')

@section('title', 'Edit Blog')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Hide the CKEditor warning banner injected in .cke_top */
        .cke_top .cke_reset_all_warning {
            display: none !important;
        }

        /* Safety: hide the entire top bar warning message */
        .cke_top[role="presentation"]>div[style*="background-color:#ffd9d9"] {
            display: none !important;
        }
    </style>

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

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Edit Blog</div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Title --}}
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $blog->title) }}" required>

                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Content --}}
                            <div class="mb-3">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6">{{ old('content', $blog->content) }}</textarea>

                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Main Image --}}
                            <div class="mb-3">
                                <label for="main_image" class="form-label">Main Image</label>
                                <input type="file" class="form-control @error('main_image') is-invalid @enderror"
                                    id="main_image" name="main_image">

                                <div class="form-text">Recommended size: 450x300px</div>

                                @if ($blog->main_image)
                                    <div class="mt-2">
                                        <p>Current Image:</p>
                                        <img src="{{ asset($blog->main_image) }}" alt="Current Image"
                                            style="max-width: 200px; border-radius: 4px;">
                                    </div>
                                @endif

                                @error('main_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-primary">Update Blog</button>
                            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
