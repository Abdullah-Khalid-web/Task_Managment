@extends('layouts/contentNavbarLayout')
@section('title', 'Projects')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Project List</h5>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            + Add Project
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success m-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Created By</th>
                    <th width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>
                        @if($project->category === \App\Models\Project::CATEGORY_PROJECT)
                            <span class="badge bg-label-primary">Project</span>
                        @else
                            <span class="badge bg-label-info">Meeting</span>
                        @endif
                    </td>
                    <td>{{ $project->starting_date->format('M d, Y') }}</td>
                    <td>{{ $project->end_date->format('M d, Y') }}</td>
                    <td>{{ $project->creator->name ?? 'N/A' }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('projects.show', $project->id) }}">View</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('projects.edit', $project->id) }}">Edit</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
