<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginOrRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function login(LoginOrRegisterRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'Invalid credentials',
            ], 401);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'User not found',
            ], 404);
        }

        return response()->json([
                'Authenticated',
                [
                    'token' => $user->createToken(
                        'API token for' . $user->email,
                        ['*'],
                        now()->addMonth())->plainTextToken
                ]
            ]
        );
    }

    public function register(LoginOrRegisterRequest $request)
    {
        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->noContent();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

    public function resetPassword() {
        return response()->noContent();
    }
}
