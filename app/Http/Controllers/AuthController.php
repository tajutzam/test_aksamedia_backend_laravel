<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends ApiController
{

    public function authenticate(LoginRequest $loginRequest)
    {
        $isLogin = Auth::attempt(['username' => $loginRequest->username, 'password' => $loginRequest->password]);
        if ($isLogin) {
            $user = User::where('username', $loginRequest->username)->first();
            Auth::login($user);
            $token = $user->createToken('apiToken')->plainTextToken;
            return $this->success([
                'token' => $token,
                'admin' => $user
            ], "Login successful", 200);
        }
        return $this->error("Invalid username or password. Please try again", 401);
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();

            if ($token) {
                $personalAccessToken = PersonalAccessToken::findToken($token);

                if ($personalAccessToken) {
                    $personalAccessToken->delete();
                }
            }

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Successfully logged out!'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Logout failed: ' . $e->getMessage()
                ],
                500
            );
        }
    }
}
