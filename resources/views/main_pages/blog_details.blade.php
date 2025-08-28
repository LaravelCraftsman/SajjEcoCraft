@extends('layouts.frontend')

@section('title')
    {{ $blog->title }}
@endsection

@section('content')
    <main style="margin:20px;">
        <div class="mb-4 pb-4"></div>
        <section class="blog-page blog-single container">
            <h3><u>{!! $blog->title !!}</u></h3>
            <br>
            {!! $blog->content !!}
        </section>
    </main>
@endsection
