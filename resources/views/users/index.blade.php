@extends('layouts/contentNavbarLayout')
@section('title', 'Users')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>User List</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            + Add User
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-label-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('users.show', $user->id) }}">View</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('users.edit', $user->id) }}">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $data->links() }}
    </div>
</div>
@endsection
