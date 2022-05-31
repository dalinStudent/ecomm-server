<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request) {
        if(Auth::user()) {
            $validate = Validator::make($request->all(), [
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'phone' => 'required|max:191',
                'email' => 'required|max:191|email',
                'address' => 'required|max:191',
                'city' => 'required|max:191',
                'state' => 'required|max:191',
                'zipcode' => 'required|max:191',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->message()
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please login to be continus!'
            ])
        }
    }
}
