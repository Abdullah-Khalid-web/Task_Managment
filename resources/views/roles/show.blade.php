@extends('layouts/contentNavbarLayout')

@section('title', 'View Role')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4 d-flex justify-content-between">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">User Management / Roles /</span> View
        </h4>

        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
            <i class="ri-pencil-line me-1"></i> Edit Role
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label fw-semibold">Role Name</label>
                <p class="mb-0">{{ ucfirst($role->name) }}</p>
            </div>

            <div>
                <label class="form-label fw-semibold mb-2">Permissions</label>
                <div>
                    @forelse($role->permissions as $permission)
                        <span class="badge bg-label-primary me-1 mb-1">
                            {{ $permission->name }}
                        </span>
                    @empty
                        <p class="text-muted">No permissions assigned</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
