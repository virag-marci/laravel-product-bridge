<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('auth-token')->plainTextToken;

            Log::info('User logged in successfully.', ['user_id' => $user->id]);

            return response()->json(['access_token' => $token], 200);
        }

        Log::warning('Failed login attempt.', ['email' => $request->input('email')]);
        return response()->json(['message' => 'Unauthorized'], 401);
    }

}
