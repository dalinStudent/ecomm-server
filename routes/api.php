<?php

use App\Models\Phone;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'login']);

// Route::resource('phones', PhoneController::class);

//Protected route
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/phones', [PhoneController::class, 'store']);
    Route::put('/phones/{id}', [PhoneController::class, 'update']);
    Route::get('/phones/{id}', [PhoneController::class, 'show']);
    Route::get('/phones', [PhoneController::class, 'index']);
    Route::get('/phones/search/{name}', [PhoneController::class, 'search']);
    Route::delete('/phones/{id}', [PhoneController::class, 'destory']);
    Route::get('stripe', 'StripePaymentController@stripe');
    Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
