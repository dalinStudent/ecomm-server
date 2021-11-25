<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

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
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'shiping_address' => 'required',
            'order_address' => 'required',
        ]);

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
        $order = Order::create($data);
        return response()->json([
			"success" => true,
			"message" => "Order created successfully.",
			"data" => $order
		]);
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
			return $this->sendError('Order not found.');
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
    public function edit($id)
    {
        $order = Order::find($id);
		if (is_null($order)) {
			return $this->sendError('Order not found.');
		}
		return response()->json([
			"success" => true,
			"message" => "Order get by id successfully.",
			"data" => $order
		]);
    }

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
