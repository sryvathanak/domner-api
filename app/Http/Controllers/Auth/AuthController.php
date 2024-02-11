<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $request->validate(([
            "email" => "required|email",
            "password" => "required"
        ]));

        // $user = User::where('email', $request->email)->first();

        // if (!$user) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'User not found.',
        //     ], 404);
        // }
        $token = JWTAuth::attempt(
            [
                "email" => $request->email,
                "password" => $request->password
            ],
            [
                'exp' => now()->addMinutes(1)->timestamp, // Set expiration time to 1 minute for testing
            ]
        );

        $user = auth()->user();
        if (empty($token)) {

            return response()->json([
                "status" => false,
                "message" => "Invalid email or password."
            ], 400);
        }

        $cookie = cookie('access_token', $token, 600000);
        return response()->json([
            "status" => true,
            "message" => "Login Successfully",
            "user" => $user,
            "access_token" => $token,

        ])->withCookie($cookie);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        return response()->json([
            "status" => true,
            "message" => "User Data",
            "user" => $user
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        // return response()->json(['message' => 'Successfully logged out']);
        $cookie = cookie('access_token', null, -1);
        return response([
            "status" => true,
            "message" => "Logged out successfully",
        ])->withCookie($cookie);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $cookie = cookie('refresh_token', $token, 60);
        return response()->json([
            'refresh_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60 //auth()->factory()->getTTL()
        ])->withCookie($cookie);
    }
}
