@extends('layouts/contentNavbarLayout')
@section('title', 'Create Task')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">Tasks /</span> Create
        </h4>
    </div>

    <!-- Task Form Card -->
    <div class="card">
        <div class="card-body">

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <!-- Task Title -->
                        <div class="mb-3">
                            <label class="form-label">Task Title *</label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Enter task title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Task description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Project -->
                        <div class="mb-3">
                            <label class="form-label">Project *</label>
                            <select name="project_id"
                                    class="form-select @error('project_id') is-invalid @enderror"
                                    required>
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Task (for sub-tasks) -->
                        <div class="mb-3">
                            <label class="form-label">Parent Task (Optional)</label>
                            <select name="parent_id"
                                    class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">None (Main Task)</option>
                                @foreach($parentTasks as $parentTask)
                                    <option value="{{ $parentTask->id }}"
                                            {{ old('parent_id') == $parentTask->id ? 'selected' : '' }}>
                                        {{ $parentTask->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assign To -->
                        <div class="mb-3">
                            <label class="form-label">Assign To (Optional)</label>
                            <select name="assigned_to"
                                    class="form-select @error('assigned_to') is-invalid @enderror">
                                <option value="">Unassigned</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i> Save Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
