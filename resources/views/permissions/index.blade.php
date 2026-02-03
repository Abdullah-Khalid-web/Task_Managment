@extends('layouts/contentNavbarLayout')

@section('title', 'Permissions')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">User Management /</span> Permissions
        </h4>

        <a href="{{ route('permissions.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Permission
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Permission Name</th>
                        <th>Guard</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td class="fw-semibold">{{ $permission->name }}</td>
                            <td>
                                <span class="badge bg-label-info">
                                    {{ $permission->guard_name }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('permissions.show', $permission->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="ri-eye-line"></i>
                                    </a>

                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="ri-pencil-line"></i>
                                    </a>

                                    <form action="{{ route('permissions.destroy', $permission->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this permission?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No permissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
