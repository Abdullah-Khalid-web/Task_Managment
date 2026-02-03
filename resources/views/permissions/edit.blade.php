@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Permission')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">User Management / Permissions /</span> Edit
        </h4>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Permission Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ $permission->name }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Guard Name</label>
                    <input type="text"
                           name="guard_name"
                           class="form-control"
                           value="{{ $permission->guard_name }}">
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="ri-save-line me-1"></i> Update Permission
                    </button>

                    <a href="{{ route('permissions.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
