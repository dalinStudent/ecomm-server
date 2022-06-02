<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        if (Auth::user()) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'phone' => 'required|max:191',
                'email' => 'required|max:191|email',
                'address' => 'required|max:191',
                'city' => 'required|max:191',
                'state' => 'required|max:191',
                'zipcode' => 'required|max:191',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ]);
            } else {

                $user_id = Auth::id();
                $orderDetail = new OrderDetail();
                $orderDetail->user_id = $user_id;
                $orderDetail->first_name = $request->first_name;
                $orderDetail->last_name = $request->last_name;
                $orderDetail->email = $request->email;
                $orderDetail->phone = $request->phone;
                $orderDetail->address = $request->address;
                $orderDetail->city = $request->city;
                $orderDetail->state = $request->state;
                $orderDetail->zipcode = $request->zipcode;

                $orderDetail->payment_mode = "COD";
                $orderDetail->save();

                $order = Order::where('user_id', $user_id)->get();

                $orderItems = [];
                foreach ($order as $item) {
                    $orderItems[] = [
                        'phone_id' => $item->phone_id,
                        'quantity' => $item->quantity,
                        'price' => $item->phone->sell_price,
                    ];

                    $item->phone->update(
                        ['quantity' => $item->phone->quantity - $item->quantity]
                    );
                }

                $orderDetail->orderItems()->createMany($orderItems);
                Order::destroy($order);

                return response()->json([
                    'status' => 200,
                    'message' => 'Order successfully',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please login to be continus!'
            ]);
        }
    }
}
