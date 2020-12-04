@extends('layouts.app')

@section('title', 'Upload Image')

@section('content')
    <!-- Main Container -->
    <div class="main-container">
        <div class="row justify-content-center">
            <div class="col-md-8 card-margin-top">
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload Image</h4>
                        <form method="post" action="{{ route('image.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label><strong>Image</strong></label>
                                <input type="file" name="img_url" class="form-control-file @error('img_url') is-invalid @enderror" id="img_url">
                                @error('img_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label><strong>Description</strong></label>
                                <textarea class="form-control @error('img_description') is-invalid @enderror" name="img_description" id="img_description" rows="3">
                                    {{ old('img_description') }}
                                </textarea>
                                @error('img_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
