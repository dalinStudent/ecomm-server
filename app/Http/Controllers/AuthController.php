<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected function register(Request $request) {

        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'address' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'address' => $fields['address'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            "success" => true,
            "statusCode" => 201,
			"message" => "User created successfully.",
			"data" => $response
		]);
    }

    public function logout(Request $request ) {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first(); 
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Email or password incorrect!'
            ], 401);
        }

        $token = $user->createToken('apptoken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            "success" => true,
            "statusCode" => 201,
			"message" => "Login successfully.",
			"data" => $response
		]);
    }
}
