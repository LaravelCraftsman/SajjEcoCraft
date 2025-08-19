@extends('layouts.app')

@section('title')
    Banners
@endsection

@section('content')
    <div class="container">
        @include('partials.alerts')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Shop Banner') }}</div>
                    <div class="card-body">
                        <form action="{{ route('update_about_banner') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <!--<label for="about_image" class="form-label">About Banner</label>-->
                                <input type="hidden" name="name" id="name" value="about">
                                <input type="file" class="form-control" id="image" name="image">
                                <br>
                                <img src="{{ url($aboutBanner->image) }}" alt="Shop Banner" width="100%">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update Banner</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Blog Banner') }}</div>
                    <div class="card-body">
                        <form action="{{ route('update_blog_banner') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            {{-- Blog Banner --}}
                            <div class="mb-3">
                                <!--<label for="blog_image" class="form-label">Blog Banner</label>-->
                                <input type="hidden" name="name" id="name" value="blog">
                                <input type="file" class="form-control" id="image" name="image">
                                <br>
                                <img src="{{ url($blogBanner->image) }}" alt="Blog Banner" width="100%">
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">Update Banner</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
