@extends('layouts/contentNavbarLayout')

@section('title', 'View Permission')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">User Management / Permissions /</span> View
        </h4>

        <a href="{{ route('permissions.edit', $permission->id) }}"
           class="btn btn-warning">
            <i class="ri-pencil-line me-1"></i> Edit
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label fw-semibold">Permission Name</label>
                <p class="mb-0">{{ $permission->name }}</p>
            </div>

            <div>
                <label class="form-label fw-semibold">Guard</label>
                <p class="mb-0">{{ $permission->guard_name }}</p>
            </div>

        </div>
    </div>

</div>
@endsection
