@extends('layouts.app')

@section('title')
    About Us
@endsection

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection


@section('scripts')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description', {
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
        CKEDITOR.replace('short_description', {
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
        CKEDITOR.replace('size', {
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('About Us') }}</div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('update_about_us') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Description Field -->
                            <div class="mb-3">
                                <textarea name="description" id="description" cols="30" rows="10"
                                    class="wysihtml5 form-control @error('description') is-invalid @enderror">{{ old('description', $description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update About Us</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
