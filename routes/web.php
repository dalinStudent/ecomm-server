<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/user', function () {
    return view('usersdashboard/usersdashboard');
});
Route::get('/', function () {
    return view('usersdashboard/home');
});
Route::get('/contact', function () {
    return view('usersdashboard/contact-us');
});
Route::get('/products', function () {
    return view('usersdashboard/phone-product');
});
Route::get('/register', function () {
    return view('usersdashboard/register');
});
Route::get('/login', function () {
    return view('usersdashboard/loginform');
});
Route::get('/admin', function () {
    return view('dashboardadmin/listproduct');
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
