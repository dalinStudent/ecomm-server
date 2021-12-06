<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Phone::all();
        $phone = Phone::all();
        return response()->json([
			"success" => true,
			"message" => "Product Phone List",
			"data" => $phone
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'img' => 'required',
        ]);

        $user_id = Auth::id();
        $data = [
            'user_id' => $user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'img' => $request->img,
        ];
        $phone = phone::create($data);
        return response()->json([
			"success" => true,
			"message" => "phone created successfully.",
			"data" => $phone
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
        $phone = Phone::find($id);
		if (is_null($phone)) {
			return $this->sendError('Product not found.');
		}
		return response()->json([
			"success" => true,
			"message" => "Product retrieved successfully.",
			"data" => $phone
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
        $phone = Phone::find($id);
		if (is_null($phone)) {
			return $this->sendError('Product not found.');
		}
		return response()->json([
			"success" => true,
			"message" => "Product get by id successfully.",
			"data" => $phone
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'img' => 'required',
        ]);
        $phone = Phone::find($id);
        $user_id = Auth::id();
        $data = [
            'user_id' => $user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'img' => $request->img,
        ];
        $phone->update($data);
        return response()->json([
			"success" => true,
			"message" => "Product updated successfully.",
			"data" => $data
		]);
    }

    /**
     * Search the specified name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Phone::where('name','like','%'.$name.'%')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone = Phone::find($id);
		$phone->delete();
		return response()->json([
			"message" => "Product deleted successfully."
		]);
    }
}
