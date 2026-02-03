@extends('layouts/contentNavbarLayout')
@section('title','View User')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>User Details</h5>
    </div>

    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Roles:</strong>
            @foreach($user->roles as $role)
                <span class="badge bg-label-primary">{{ $role->name }}</span>
            @endforeach
        </p>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
