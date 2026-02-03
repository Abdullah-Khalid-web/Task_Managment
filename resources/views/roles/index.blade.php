@extends('layouts/contentNavbarLayout')

@section('title', 'Roles Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">User Management /</span> Roles
        </h4>

        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Role
        </a>
    </div>

    <!-- Roles Table Card -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Role Name</th>
                        <th>Permissions</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ ucfirst($role->name) }}</span>
                            </td>

                            <td>
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-label-primary me-1 mb-1">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('roles.edit', $role->id) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="ri-pencil-line"></i>
                                    </a>

                                    <form action="{{ route('roles.destroy', $role->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this role?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                No roles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
