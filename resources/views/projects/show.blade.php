@extends('layouts/contentNavbarLayout')
@section('title', 'View Project')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Project Details</h5>
        <div>
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Title:</label>
                <p>{{ $project->title }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Category:</label>
                <p>
                    @if($project->category === \App\Models\Project::CATEGORY_PROJECT)
                        <span class="badge bg-label-primary">Project</span>
                    @else
                        <span class="badge bg-label-info">Meeting</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Starting Date:</label>
                <p>{{ $project->starting_date->format('F d, Y') }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">End Date:</label>
                <p>{{ $project->end_date->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Created By:</label>
                <p>{{ $project->creator->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Created At:</label>
                <p>{{ $project->created_at->format('F d, Y H:i:s') }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Duration:</label>
                <p>{{ $project->starting_date->diffInDays($project->end_date) }} days</p>
            </div>
        </div>
    </div>
</div>
@endsection
