@extends('layouts/contentNavbarLayout')
@section('title', 'Add Project')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add Project</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Starting Date *</label>
                    <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" value="{{ old('starting_date') }}" required>
                    @error('starting_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category *</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="mb-3">
                <label class="form-label">Created By (Optional)</label>
                <select name="created_by" class="form-select">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('created_by') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Leave empty to assign current user</small>
            </div> --}}

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
