<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('usersdashboard/register');
});
Route::get('/login', function () {
    return view('usersdashboard/loginform');
});

// Route List 
Route::get('/userlist', function () {
    return view('dashboardadmin/userlist');
});
Route::get('/listproduct', function () {
    return view('dashboardadmin/listproduct');
});
Route::get('/listpayment', function () {
    return view('dashboardadmin/listpayment');
});
Route::get('/orderlist', function () {
    return view('dashboardadmin/orderlist');
});
// Route Create 
Route::get('/createproduct', function () {
    return view('dashboardadmin/createproduct');
});
Route::get('/createuser', function () {
    return view('dashboardadmin/createuser');
});
Route::get('/createorder', function () {
    return view('dashboardadmin/createorder');
});
Route::get('/createpayment', function () {
    return view('dashboardadmin/createpayment');
});


// Route::get('orders',[OrderController::class,'sendMailDetail']);
// Route::get('send-mail', function () {
//     $details = [
//         'title' => 'Mail from ItSolutionStuff.com',
//         'body' => 'This is for testing email using smtp'
//     ];
//     \Mail::to('da.duon1997@gmail.com')->send(new \App\Mail\OrderMail($details));
//     dd("Email is Sent.");
//     });
