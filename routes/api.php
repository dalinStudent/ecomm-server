<?php

use App\Models\Phone;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// public route
Route::post('/register', [AuthController::class, 'register']);
// Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/phones', [PhoneController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'viewPhoneEachCat']);
Route::get('/phones/{cat_slug}/{phone_slug}', [CategoryController::class, 'viewPhoneByCat']);

//Protected route
Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    Route::get('/phones/{id}', [PhoneController::class, 'show']);
    Route::get('/phones/search/{name}', [PhoneController::class, 'search']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/orders',[OrderController::class,'index']);
    Route::post('/orders',[OrderController::class,'store']);
    // Route::get('/orders/{id}',[OrderController::class,'show']);
    Route::get('/orders/{id}/create',[OrderController::class,'create']);
    Route::put('/orders/{id}',[OrderController::class,'update']);
    Route::delete('/orders/{id}',[OrderController::class,'destroy']);
    Route::get('/orders/{id}/edit',[OrderController::class,'edit']);

    Route::post('/orders/add-cart',[OrderController::class,'store']);
    Route::get('/orders/view-cart',[OrderController::class,'viewCart']);
    Route::put('/orders/update-quantity/{order_id}/{scope}',[OrderController::class,'updateQuantity']);
    Route::delete('/orders/remove-cart/{order_id}', [OrderController::class, 'removeCart']);

    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);


    Route::get('/checkingAuthenticated', function() {
        return response()->json(['message' => 'You are in', 'status'=>200], 200);
    });

});

Route::group(['middleware' => ['admin','auth:sanctum']], function () {

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('/phones', [PhoneController::class, 'store']);
    Route::put('/phones/{id}', [PhoneController::class, 'update']);
    Route::delete('/phones/{id}', [PhoneController::class, 'destroy']);
    Route::get('/phones/search/{name}', [PhoneController::class, 'search']);

    Route::get('/users', [AuthController::class, 'index']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
