@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4 offset-md-4 top-margin">
        <div class="card mb-3 text-center">
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <fieldset>
                        <h3 class="card-title">Reset Password</h3>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
