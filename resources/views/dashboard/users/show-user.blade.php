@extends('template')
@section('dashboard-content')

@include('dashboard.includes.alerts')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><a href='{{ route('user.add') }}' class="btn btn-primary">Add New User</a></p>
@endsection
