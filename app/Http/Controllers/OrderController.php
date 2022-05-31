<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use Carbon\Carbon;
use App\Mail\OrderEmail;
use App\Models\Phone;
use App\Models\OrderDetail;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            "success" => true,
            "message" => "Order List",
            "data" => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $phone = Phone::find($id);
        return response()->json([
            "success" => true,
            "message" => "Get phone",
            "data" => $phone
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()) {
            $user_id = Auth::id();
            $phone_id = $request->phone_id;

            $phoneCheck = Phone::where('id', $phone_id)->first();
            if ($phoneCheck) {
                if (Order::where('phone_id', $phone_id)->where('user_id', $user_id)->exists()) {
                    return response()->json([
                        'status' => 409,
                        'message' => $phoneCheck->name . ' Already added to cart'
                    ]);
                } else {
                    $data = [
                        'user_id' => $user_id,
                        'phone_id' => $phone_id,
                    ];

                    $order = Order::create($data);
                    $phone = Phone::find($user_id);

                    $email = Auth::user()->email;
                    Mail::to($email)->send(new OrderEmail($email));

                    $order->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Add to cart successfully',
                        'data' => $phone
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Phone not found!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please Login before you want to add to cart !'
            ]);
        }
    }

    public function viewCart()
    {
        if (Auth::user()) {
            $user_id = Auth::id();
            $cartItems = Order::where('user_id', $user_id)->get();

            return response()->json([
                'status' => 200,
                'cart' => $cartItems,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please login before you can view all cart!',
            ]);
        }
    }

    public function updateQuantity($order_id, $scope)
    {
        if (Auth::user()) {
            $user_id = Auth::id();
            $cartItems = Order::where('id', $order_id)->where('user_id', $user_id)->first();
            if ($scope == "incre") {
                $cartItems->quantity += 1;
            } else if ($scope == "dec") {
                $cartItems->quantity -= 1;
            }
            $cartItems->update();

            return response()->json([
                'status' => 200,
                'message' => 'Quantity updated!'
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to be continue!',
            ]);
        }
    }

    public function removeCart($order_id)
    {
        if (Auth::user()) {
            $user_id = Auth::id();
            $cartItems = Order::where('id', $order_id)->where('user_id', $user_id)->first();
            if ($cartItems) {
                $cartItems->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cart remove successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cart item not found!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to be continue!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json([
                "status" => 404,
                "message" => "Phone not found",
                "data" => $order
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Order retrieved successfully.",
            "data" => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $order = Order::find($id);
    // 	if (is_null($order)) {
    // 		return $this->sendError('Order not found.');
    // 	}
    // 	return response()->json([
    // 		"success" => true,
    // 		"message" => "Order get by id successfully.",
    // 		"data" => $order
    // 	]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
            'shiping_address' => 'required',
            'order_address' => 'required',
        ]);
        $order = Order::find($id);
        $user_id = Auth::id();
        $current = Carbon::now();
        $data = [
            'user_id' => $user_id,
            'amount' => $request->amount,
            'shiping_address' => $request->shiping_address,
            'order_address' => $request->order_address,
            'order_date' => $current,
            'order_status' => 0,
        ];
        $order->update($data);
        return response()->json([
            "success" => true,
            "message" => "Order updated successfully.",
            "data" => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return response()->json([
            "success" => true,
            "message" => "Order deleted successfully.",
            "data" => $order
        ]);
    }
}
