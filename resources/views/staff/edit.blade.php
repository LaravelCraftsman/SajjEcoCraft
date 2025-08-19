@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Staff</div>

                    <div class="card-body">
                        @include('partials.alerts')

                        <form action="{{ route('staff.update', $staff->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $staff->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $staff->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                <input type="number" maxlength="14" name="phone" class="form-control"
                                    value="{{ old('phone', $staff->phone) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <small>(Leave blank to keep
                                        current)</small></label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="create" id="create"
                                        {{ old('create', $staff->create) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="create">Create</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="edit" id="edit"
                                        {{ old('edit', $staff->edit) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit">Edit</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="delete" id="delete"
                                        {{ old('delete', $staff->delete) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="delete">Delete</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update Staff</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
