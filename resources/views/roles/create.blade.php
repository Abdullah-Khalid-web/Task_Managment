@extends('layouts/contentNavbarLayout')

@section('title', 'Create Role')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">User Management / Roles /</span> Create
        </h4>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <!-- Role Name -->
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="e.g. Admin, Manager"
                           required>
                </div>

                <!-- Permissions -->
                <div class="mb-3">
                    <label class="form-label mb-2">Assign Permissions</label>

                    <!-- In create.blade.php -->
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input"
                                          type="checkbox"
                                          name="permissions[]"
                                          value="{{ $permission->id }}"> <!-- This should now be UUID -->
                                    <label class="form-check-label">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i> Save Role
                    </button>

                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
