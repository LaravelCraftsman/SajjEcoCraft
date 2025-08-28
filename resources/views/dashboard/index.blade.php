@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-header">{{ __('Total Visitors') }}</div>

                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
