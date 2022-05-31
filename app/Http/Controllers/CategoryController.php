<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Phone;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();

        return response()->json([
			"success" => true,
            "status" => 200,
			"message" => "Category List",
			"data" => $category
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
            'slug' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
        ];

        $category = Category::create($data);

        return response()->json([
			"success" => true,
			"message" => "Category created successfully.",
			"data" => $category
		]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                "success" => true,
                "message" => "Category retrieved successfully.",
                "data" => $category
            ]);
            
		} else {
            return response()->json([
                "status" => 404,
                "message" => "Category not found"
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (is_null($category)) {
            return response()->json([
                "status" => 404,
                "message" => "Category not found"
            ]);
		} else {
            return response()->json([
                "success" => true,
                "message" => "Category retrieved successfully.",
                "data" => $category
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $category = Category::find($id);

        if($category) {
            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ];

            $category->update($data);
            $category->save();

            return response()->json([
                "success" => true,
                "message" => "Category updated successfully.",
                "data" => $data                                    
            ]);
        } else {
            return response()->json([
                "statue" => 404,
                "message" => "Category not found.",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();

            return response()->json([
                "status" => 200,
                "message" => "Phone deleted successfully."
            ]);

            $category->save();
        }
    }

    public function viewPhoneEachCat($slug) {
        $category = Category::where('slug', $slug)->where('status', '0')->first();

        if($category) {
            $phone = Phone::where('category_id', $category->id)->get();

            if($phone) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Get phone each category successfully',
                    'data' => [
                        'phone' => $phone,
                        'category' => $category
                    ],
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No phone available!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No phone found in this category'
            ]);
        }
    }

    public function viewPhoneByCat($cat_slug, $phone_slug) {

        $category = Category::where('slug', $cat_slug)->where('status', '0')->first();

        if($category) {
            $phone = Phone::where('category_id', $category->id)
                            ->where('slug', $phone_slug)
                            ->first();

            if($phone) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Get phone each category successfully',
                    'data' => [
                        'phone' => $phone,
                        'category' => $category
                    ],
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No phone available!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such category found!'
            ]);
        }
    }
}
