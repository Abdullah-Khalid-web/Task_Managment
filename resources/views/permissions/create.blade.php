@extends('layouts/contentNavbarLayout')

@section('title', 'Create Permission')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">User Management / Permissions /</span> Create
        </h4>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Permission Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="e.g. create-user, edit-task"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Guard Name</label>
                    <input type="text"
                           name="guard_name"
                           value="web"
                           class="form-control">
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="ri-save-line me-1"></i> Save Permission
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
