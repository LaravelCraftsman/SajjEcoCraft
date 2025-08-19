@extends('layouts.app')

@section('title')
    Blogs
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Blogs') }}
                        <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm" style="float: right;">Add New</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th width="10%" scope="col">Sr.No</th>
                                    <th width="40%" scope="col">Title</th>
                                    <th width="20%" scope="col">Image</th>
                                    <th width="10%" scope="col">Date</th>
                                    <th width="20%" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <a href="{{ $item->main_image }}" target="_blank">
                                                <img src="{{ $item->main_image }}" alt="{{ $item->main_image }}"
                                                    style="width: 100px; height: auto">
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                        <td>
                                            <x-table-actions route="blogs" :id="$item->id" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
