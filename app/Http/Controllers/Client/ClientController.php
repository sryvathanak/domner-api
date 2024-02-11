<?php

namespace App\Http\Controllers\Client;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Client\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }
    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'phone_number' => 'required|regex:/^[0-9]+$/|min:8|unique:clients',
            'email' => 'required|email|unique:clients',
            'password' => 'required|string|min:8',
            'service_id' => 'required'
        ]);

        $client_exist = Client::where('email', $request->email)->first();
        if ($client_exist) {
            return response([
                "message" => "Email Already Exist !",
                "success"  => false
            ], 400);
        }
        $username_exist = Client::where('username', $request->username)->first();

        if ($username_exist) {
            return response()->json([
                "message" => "Username Already Exist !",
                "success"  => false
            ], 400);
        }
        $client = Client::create($request->all());

        return response()->json([
            "message" => "Create Successfully !",
            "success"  => true,
            "client" => $client
        ]);
    }



    public function delete($id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            return response()->json(
                [
                    'message' => 'Delete Has Success',
                    'status' => true,
                ]
            );
        }
    }



    // /**
    //  * Get a JWT via given credentials.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    public function login(Request $request)
    {
        $request->validate(([
            "email" => "required|email",
            "password" => "required"
        ]));



        $clientCredentials = $request->only('email', 'password');

        if (!Auth::guard('api_clients')->attempt($clientCredentials)) {
            return response()->json(['message' => 'Invalid email or password.', "status" => false], 400);
        }
        $client = auth()->guard('api_clients')->user();
        $token = Auth::guard('api_clients')->attempt($clientCredentials);

        $cookie = cookie('client_access_token', $token, 600000);
        return response([
            "status" => true,
            "message" => "Login Successfully",
            "client" => $client,
            "client_access_token" => $token
        ])->withCookie($cookie);
    }

    public function logout()
    {
        auth()->guard('api_clients')->logout();


        $cookie = cookie('client_access_token', null, -1);
        return response([
            "status" => true,
            "message" => "Logged out successfully",
        ])->withCookie($cookie);
    }

    public function update(Request $request)
    {
        $client = auth()->check() ? auth()->user()->id : null;
        $client = Client::find($client);
        if (!$client) {
            return response()->json([
                "message" => "Unauthorized",
                "stats" => false,

            ], 403);
        }
        if ($client) {
            if ($request->old_password) {
                if (!Hash::check($request->old_password, $client->password)) {
                    return response()->json([
                        "message" => "Password Incorrect",
                        "stats" => false,

                    ], 400);
                }
            }
        }

        if ($request->filled('new_password')) {
            $client->update([
                "password" => bcrypt($request->new_password),
            ]);
        }
        $client->update([
            "username" => $request->username,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "logo" => $request->logo

        ]);
        return response()->json([
            "message" => "Profie Updated",
            "stats" => true,
            "data" => $client
        ], 200);
    }
}
