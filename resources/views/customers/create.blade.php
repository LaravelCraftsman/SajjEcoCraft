@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add New Customer</div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('customers.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                <input type="number" maxlength="14" name="phone" class="form-control"
                                    value="{{ old('phone') }}" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Create Customer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
