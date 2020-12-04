@extends('layouts.app')

@section('title', 'Edit Details')

@section('content')
    <!-- Main Container -->
    <div class="main-container">
        <div class="row justify-content-center">
            <div class="card mb-3 col-md-8 card-margin-top">
                <div class="card-body">
                    <h4 class="card-title">Upload Image</h4>
                    <form method="POST" action="{{ route('image.update', $image->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label><strong>Old Image</strong></label>
                            <div>
                                <img src="{{ url($image->img_url) }}" alt="" class="img-thumbnail" height="70px;" width="80px;">
                                <input type="hidden" name="old_image" value="{{ $image->img_url }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label><strong>Choose New Image</strong></label>
                            <input type="file" name="img_url" class="form-control-file" id="img_url">
                        </div>
                        <div class="form-group">
                            <label><strong>Description</strong></label>
                            <textarea class="form-control" name="img_description" id="img_description" rows="3">
                                {{ $image->img_description }}
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

