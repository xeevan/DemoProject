@extends('layouts.app')

@section('title', 'User Home')

@section('content')
    <!-- Main Container -->
    <div class="main-container">
        <div class="row">
            @if($message = Session::get('success'))
                <div class="col-md-12 card-margin-top">
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                </div>
            @endif
            @forelse($images as $image)
                <div class="col-md-4 card-margin-top">
                    <div class="card">
                        <div class="item-image-container">
                            <img src="{{ url($image->img_url) }}" class="item-image" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <hr>
                            <p class="card-text truncate">{{ $image->img_description }}</p>
                            <a href="{{ route('image.show', $image->id) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('image.edit', $image->id) }}" class="btn btn-secondary">Edit</a>
                            <a href="{{ route('image.destroy', $image->id) }}" class="btn btn-danger" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete it?')){document.getElementById('post-delete-form').submit();}">Delete</a>
                            <form action="{{ route('image.destroy', $image->id) }}" method="POST" class="d-none" id="post-delete-form">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4 offset-4 card-margin-top text-center">
                    <h5>Nothing to Display</h5>
                </div>
            @endforelse
        </div>
    </div>
@endsection
