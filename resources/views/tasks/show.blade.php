@extends('layouts/contentNavbarLayout')
@section('title', 'Task Details')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Task Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Tasks /</span> {{ $task->title }}
            </h4>
            @if($task->parent)
                <small class="text-muted">
                    <i class="ri-subtract-line me-1"></i> Sub-task of: {{ $task->parent->title }}
                </small>
            @endif
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">
                <i class="ri-pencil-line me-1"></i> Edit
            </a>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                <i class="ri-arrow-left-line me-1"></i> Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Left Column: Task Details -->
        <div class="col-md-8">
            <!-- Task Info Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Task Information</h5>
                    <span class="badge {{ $task->getStatusBadgeClass() }}">
                        {{ $task->getStatusText() }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Project:</label>
                            <p class="mb-2">
                                <span class="badge bg-label-primary">{{ $task->project->title }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created By:</label>
                            <p class="mb-2">{{ $task->creator->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Assigned To:</label>
                            <p class="mb-2">{{ $task->assignee->name ?? 'Unassigned' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Created At:</label>
                            <p class="mb-2">{{ $task->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p class="mb-0">{{ $task->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Remarks Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Remarks</h5>
                </div>
                <div class="card-body">
                    <!-- Add Remark Form -->
                    <form action="{{ route('tasks.remarks.store', $task->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Add Remark</label>
                            <textarea name="remark"
                                      class="form-control @error('remark') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Enter your remark here..."
                                      required>{{ old('remark') }}</textarea>
                            @error('remark')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attachment (Optional)</label>
                            <input type="file"
                                   name="attachment"
                                   class="form-control @error('attachment') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max: 5MB | Allowed: JPG, PNG, PDF, DOC</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-chat-1-line me-1"></i> Add Remark
                        </button>
                    </form>

                    <!-- Remarks Timeline -->
                    <div class="remarks-timeline mt-4">
                        @forelse($task->remarks as $remark)
                            <div class="timeline-item mb-4">
                                <div class="timeline-icon bg-primary">
                                    <i class="ri-chat-1-line text-white"></i>
                                </div>

                                <div class="timeline-content card shadow-sm">
                                    <div class="card-body p-3">
                                        <!-- Remark Header -->
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $remark->user->name }}</h6>
                                                <small class="text-muted">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    {{ $remark->created_at->format('Y-m-d h:i A') }}
                                                </small>
                                            </div>

                                            <div class="d-flex gap-2">
                                                @if($remark->hasAttachment())
                                                    <a href="{{ $remark->getAttachmentUrl() }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="ri-attachment-line me-1"></i>
                                                        {{ $remark->getAttachmentFilename() }}
                                                    </a>
                                                @endif

                                                <form action="{{ route('tasks.remarks.destroy', [$task->id, $remark->id]) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Delete this remark?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Remark Content -->
                                        <p class="mb-0 mt-2">{{ $remark->remark }}</p>

                                        <!-- User Info -->
                                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                            <small class="text-muted">
                                                <i class="ri-user-line me-1"></i>
                                                {{ $remark->user->name }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="ri-time-line me-1"></i>
                                                {{ $remark->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="ri-chat-1-line display-4"></i>
                                <p class="mt-2">No remarks yet. Be the first to comment!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sub-tasks & Actions -->
        <div class="col-md-4">
            <!-- Sub-tasks Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sub-tasks</h5>
                    <span class="badge bg-label-info">{{ $task->subtasks->count() }}</span>
                </div>
                <div class="card-body">
                    @forelse($task->subtasks as $subtask)
                        <div class="subtask-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ $subtask->title }}</h6>
                                <span class="badge {{ $subtask->getStatusBadgeClass() }} badge-sm">
                                    {{ $subtask->getStatusText() }}
                                </span>
                            </div>
                            <p class="small text-muted mb-2">{{ Str::limit($subtask->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Assigned: {{ $subtask->assignee->name ?? 'None' }}</small>
                                <a href="{{ route('tasks.show', $subtask->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted">
                            <i class="ri-subtract-line display-4"></i>
                            <p class="mt-2">No sub-tasks</p>
                        </div>
                    @endforelse

                    <div class="mt-3">
                        <a href="{{ route('tasks.create') }}?parent_id={{ $task->id }}"
                           class="btn btn-outline-primary w-100">
                            <i class="ri-add-line me-1"></i> Add Sub-task
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <!-- Status Update Form -->
                    <form action="{{ route('tasks.status.update', $task->id) }}" method="POST" class="mb-3">
                        @csrf
                        <label class="form-label">Update Status</label>
                        <div class="d-flex gap-2">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="pending" {{ $task->isPending() ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->isInProgress() ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->isCompleted() ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </form>

                    <!-- Delete Task -->
                    <form action="{{ route('tasks.destroy', $task->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="ri-delete-bin-line me-1"></i> Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
/* Timeline Styles */
.timeline-item {
    position: relative;
    padding-left: 50px;
}

.timeline-item:last-child .timeline-content {
    border-left: none;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: -20px;
    width: 2px;
    background: #dee2e6;
    z-index: 1;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-icon {
    position: absolute;
    left: 15px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #0d6efd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    color: white;
    z-index: 2;
}

.timeline-content {
    position: relative;
    border-left: 3px solid #0d6efd;
    padding-left: 15px;
    margin-left: 5px;
}

.timeline-content .card {
    border-left: none;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Subtask Styles */
.subtask-item {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.subtask-item:hover {
    background-color: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

/* Custom Card Styles */
.card {
    border: 1px solid #e0e0e0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .timeline-item {
        padding-left: 40px;
    }

    .timeline-icon {
        left: 10px;
    }
}
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
