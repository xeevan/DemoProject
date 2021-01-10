@extends('layouts.app')

@section('title', 'Posts')

@section('content')
	<!-- Main Container -->
    <div class="main-container">
        <div class="row justify-content-center">
            <div class="card mb-3 col-md-8 card-margin-top">
                <div class="card-body">
                    <div class="flex-header">
                        <h4 class="card-title">Images</h4>
                        <h5 class="float-right">Sort By :<a href="{{ route('admin.users.posts') }}"> Date and Time |
                            @if(Session::get('sortOrder')=='desc')
                                desc
                            @else
                                asc
                            @endif
                            </a> | <a href="{{ route('admin.users.posts_by_user') }}">User</a></h5>
                    </div>
                    <div>
                        @if(!Session::get('by_user'))
                            @if(Session::get('sortOrder')=='desc')
                                <span class="badge badge-info">Sorted in Ascending order</span>                                
                            @else
                                <span class="badge badge-info">Sorted in Descending order</span>
                            @endif 
                        @else
                            <span class="badge badge-info">Sorted by User</span>
                        @endif 
                    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Uploaded By</th>
                            <th scope="col">Uploaded At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($images as $image)
                            <tr>
                                <!-- <th scope="row">{{ $image->id }}</th> -->
                                <td><img src="{{ url($image->img_url) }}" alt="..." height="40px" width="60px"></td>
                                <td>{{ $image->img_description }}</td>
                                <td>
                                    @if($sort_by_date)
                                        {{ $image->user->name }}
                                    @else
                                        {{ $image->name }}
                                    @endif
                                </td>
                                <td>{{ $image->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>                        
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $images->links() }}
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection