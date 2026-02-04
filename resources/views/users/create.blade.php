@extends('layouts/contentNavbarLayout')
@section('title', 'Add User')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add User</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password *</label>
                <input type="password" name="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" required>
                @error('confirm-password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Roles *</label>
                <select name="roles[]" class="form-control @error('roles') is-invalid @enderror" multiple required>
                    <option value="">Select Roles</option>
                    @foreach($roles as $key => $value)
                        <option value="{{ $key }}" {{ in_array($key, old('roles', [])) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl to select multiple roles</small>
                @error('roles')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
