@extends('layouts.app')

@section('title', 'Image Details')

@section('content')
    <!-- Main Container -->
    <div class="main-container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 card-margin-top">
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                <div class="card card-margin-bottom">
                    <div class="item-image-container">
                        <img src="{{ url($image->img_url) }}" class="item-image" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><b>Description</b></h5>
                        <hr>
                        <p class="card-text">{{ $image->img_description }}</p>
                        <p class="card-text">{{ $image->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
