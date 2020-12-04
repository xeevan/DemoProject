@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="col-md-4 offset-md-4 top-margin">
        <div class="card mb-3 text-center">
            <div class="card-body">
                <h4 class="card-title">Demo Project</h4>
                <form method="post" action="{{ route('register') }}" novalidate>
                    @csrf
                    <fieldset>
                        <h3 class="card-title">Sign Up</h3>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
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
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Sign Up</button>
                        </div>

                    </fieldset>

                    <a href="{{ URL::route('login')  }}">Sign In</a>

                </form>
            </div>
        </div>
    </div>
@endsection
