<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Phone;
use Illuminate\Http\Request;
use File;
use Validator;

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
            'name' => 'required|max:20|min:3',
            'description' => 'required|max:500|min:10',
            'price' => 'required|integer',
            'img' => 'required|mimes:jpg,jpeg,png,gif',
        ]);
        $image = $request->file('img');
        $upload = $image->getClientOriginalName();
        $path = 'image/phones/';
        $path = move_uploaded_file($image->getPathName(), $path. $upload);

        $user_id = Auth::id();
        $data = [
            'user_id' => $user_id,
            'name' => $request->Input('name'),
            'description' => $request->Input('description'),
            'price' => $request->$request->Input('price'),
            'img'=> $upload,
        ];
        
        $phone = Phone::create($data);
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
            'description' => 'required|max:500|min:10',
            'price' => 'required',
            'img' => 'required|mimes:jpg,jpeg,png,gif',
        ]);
        $image = $request->file('img');
        $upload = $image->getClientOriginalName();
        $path = 'image/phones/';
        $path = move_uploaded_file($image->getPathName(), $path. $upload);
        $phones = Phone::find($id);
        $user_id = Auth::id();
        $data = [
            'user_id' => $user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'img' => $upload,
        ];
        $phones->update($data);
        return response()->json([
			"success" => true,
			"message" => "Order updated successfully.",
			"data" => $data
		]);
        // $user_id = Auth::id();
        // $phone = Phone::find($id);
        // dd($phone);
        // $data = [
        //     'user_id' => $user_id,
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'img' => $request->img,
        // ];
        // $phone->update($data);
        // return response()->json([
		// 	"success" => true,
		// 	"message" => "Product updated successfully.",
		// 	"data" => $data
		// ]);
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
