@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Add New Slider</h3>

        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('sliders.form', ['slider' => null])

                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
