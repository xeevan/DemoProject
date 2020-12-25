<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $validated_data['password'] = Hash::make($request->password);

        $user = User::create($validated_data);
        $access_token = $user->createToken('auth_token')->accessToken;
        return response([
            'user' => $user,
            'access_token' => $access_token
        ]);
    }

    public function login(Request $request)
    {
        $validated_data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!auth()->attempt($validated_data))
        {
            return response([
                'message' => 'Credentials do not match !!'
            ]);
        }

        $access_token = auth()->user()->createToken('auth_token')->accessToken;
        return response([
            'user' => auth()->user(),
            'access_token' => $access_token
        ]);
    }

    public function forgot(Request $request)
    {
        $email = $request->validate([
            'email' => ['required', 'email']
        ]);
        Password::sendResetLink($email);
        return response([
            'message' => 'Password Reset link sent to your email.'
        ]);
    }

    public function reset(Request $request)
    {
        $validated_data = $request->validate([
            'email' => ['required', 'email', 'exists:App\User'],
            'password' => ['required', 'min:8', 'confirmed'],
            'token' => ['required']
        ]);

        $reset_status = Password::reset($validated_data, function($user, $password){
            $user->password = Hash::make($password);
            $user->save();
        });

        if($reset_status == Password::INVALID_TOKEN)
        {
            return response([
                'error' => 'Invalid Token'
            ]);
        }
        return response([
            'message' => 'Password reset successful.'
        ]);
    }

    public function logout(Request $request)
    {
        $token = auth()->user()->token();
        $token->revoke();
        return response([
            'message' => 'User logged out'
        ]);
    }
}
