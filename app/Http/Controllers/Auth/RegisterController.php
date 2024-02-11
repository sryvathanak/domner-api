<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'phone_number' => 'regex:/^[0-9]+$/|min:8|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user_exist = User::where('email', $request->email)->first();
        if ($user_exist) {
            return response([
                "message" => "Email Already Exist !",
                "status"  => false
            ], 400);
        }
        if ($request->password !== $request->confirm_password) {
            return response()->json(['message' => 'The password and confirm password must match'], 400);
        }

        $user = User::create($request->all());

        return response()->json([
            "message" => "Create Successfully !",
            "status"  => true,
            "user" => $user
        ]);
    }

    public function update(Request $request)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                "message" => "Unauthorized",
                "status" => false,

            ], 403);
        }
        if ($user) {
            if ($request->old_password) {
                if (!Hash::check($request->old_password, $user->password)) {
                    return response()->json([
                        "message" => "Password Incorrect",
                        "status" => false,

                    ], 400);
                }
            }
        }
        $name_profile = '';
        if ($request->has('profile')) {
            $path_profile = 'C:/Users/User/Documents/domner-app/domner/src/storage/upload/images/';
            $profile = $request->profile;
            $name_profile = time() . '.' . $profile->getClientOriginalExtension();
            //  $path_logo = storage_path('app/buss/upload');
            $profile->move($path_profile, $name_profile);
        }

        $user->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "phone" => $request->phone,
            "profile" => $name_profile,
            // "password" => $request->password,
        ]);

        return response()->json([
            "message" => "Profie Updated",
            "status" => true,
            "data" => $user
        ], 200);
    }

    public function get_cookie(Request $request)
    {
        $accessToken = $request->cookie('access_token');

        return response()->json([
            'access_token' => $accessToken,

        ]);
    }

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
