@extends('layouts.frontend')

@section('title', 'Blogs')


@section('content')
    <main>
        <section class="blog-page-title mb-4 mb-xl-5">
            <div class="title-bg">
                <img loading="lazy" src="{{ $banner->image }}" width="1780" height="420" alt="">
            </div>
            <div class="container">
                <h2 class="page-title">Blogs</h2>

                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="{{ url('/') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="{{ route('blogs') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Blogs</a>
                </div><!-- /.breadcrumb -->
            </div>
        </section>
        <section class="blog-page container">
            <h2 class="d-none">The Blog</h2>
            <div class="blog-grid row row-cols-1 row-cols-md-2 row-cols-xl-3">
                @foreach ($blogs as $blog)
                    <a href="{{ route('blog.details', $blog->slug) }}" class="blog-grid__item-link"
                        style="text-decoration: none; color: inherit; display: block;">
                        <div class="blog-grid__item">
                            <div class="blog-grid__item-image">
                                <img loading="lazy" class="h-auto" src="{{ $blog->main_image }}" width="450"
                                    height="400" alt="{{ $blog->title }}">
                            </div>
                            <div class="blog-grid__item-detail">
                                <div class="blog-grid__item-title">
                                    {{ $blog->title }}
                                </div>
                                <div class="blog-grid__item-content">
                                    <span class="readmore-link">Continue Reading</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach


            </div>
            {{ $blogs->links('partials.custom_pagination') }}

        </section>
    </main>
@endsection
