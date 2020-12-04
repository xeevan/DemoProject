@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="col-md-4 offset-md-4 top-margin">
        <div class="card mb-3 text-center">
            <div class="card-body">
                <h4 class="card-title">Demo Project</h4>
                <form method="post" action="{{ route('login') }}"novalidate>
                    @csrf
                    <fieldset>
                        <h3 class="card-title">Sign In</h3>
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
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <a href="{{ url('password/reset') }}">Forgot password?</a>
                    </fieldset>

                    <a class="btn btn-link" href="{{ route('register') }}">Sign Up</a>

                </form>
            </div>
        </div>
    </div>
@endsection
