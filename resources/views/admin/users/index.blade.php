@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
        <!-- Main Container -->
        <div class="main-container">
            <div class="row justify-content-center">
                <div class="card mb-3 col-md-8 card-margin-top">
                    <div class="card-body">
                        <h4 class="card-title">Users</h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.post', $user->id) }}" type="button" class="btn btn-primary btn-sm float-left">View Posts</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="float-left" onclick="return confirm('Are you sure you want to delete?')">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
