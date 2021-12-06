<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'address' => 'required|string',
            'phone_number' => 'required|numeric|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $tokenTwilio = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $tokenTwilio);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($fields['phone_number'], "sms");

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'address' => $fields['address'],
            'phone_number' => $fields['phone_number'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    protected function verify(Request $request)
    {
        $fields = $request->validate([
            'verification_code' => 'required|numeric',
            'phone_number' => 'numeric',
        ]);
        /* Get credentials from .env */
        $tokenTwilio = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $tokenTwilio);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($fields['verification_code'], array('to' => $fields['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $fields['phone_number']))->update(['isVerified' => true]);
            /* Authenticate user */
            Auth::login($user->first());
            return [
                'message' => 'Phone number verified'
            ];
        }
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

        return response($response, 201);
    }
}
