@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="col-md-4 offset-md-4 top-margin">
        <div class="card mb-3 text-center">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h4 class="card-title">Reset Password</h4>
                <form method="post" action="{{ route('password.email') }}"novalidate>
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
