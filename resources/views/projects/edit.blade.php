@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Project')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Project</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('projects.update', $project->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $project->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Starting Date *</label>
                    <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" value="{{ old('starting_date', $project->starting_date->format('Y-m-d')) }}" required>
                    @error('starting_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category *</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}" {{ old('category', $project->category) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Created By</label>
                <select name="created_by" class="form-select">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('created_by', $project->created_by) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
