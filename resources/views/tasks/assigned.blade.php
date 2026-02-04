@extends('layouts/contentNavbarLayout')
@section('title', 'My Tasks')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Tasks /</span> Assigned to Me
        </h4>

        <div>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary me-2">
                <i class="ri-list-check-2 me-1"></i> All Tasks
            </a>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i> Add Task
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tasks Table Card -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Task Title</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($task->parent_id)
                                        <i class="ri-subtract-line text-muted me-2"></i>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $task->title }}</h6>
                                        <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-primary">{{ $task->project->title ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <form action="{{ route('tasks.status.update', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm status-select"
                                            onchange="this.form.submit()">
                                        <option value="pending" {{ $task->isPending() ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $task->isInProgress() ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->isCompleted() ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                {{ $task->creator->name ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $task->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No tasks assigned to you.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $tasks->links() }}
        </div>
    </div>

</div>

<style>
.status-select {
    min-width: 120px;
    cursor: pointer;
}
.status-select:focus {
    box-shadow: none;
}
</style>
@endsection
