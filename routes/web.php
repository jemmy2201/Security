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

// user
Route::get('/', function () {
    return view('login');
});

//Route::get('/personal/particular/{value_application}/{value_request}/','HomeController@personaldata')->name('personal.particular');
Route::get('/personal/particular', function () {
    return view('personal_particular');
});
Route::get('/submission', function () {
    return view('submission');
});
Route::get('/book/appointment', function () {
    return view('book_appointment');
});
Route::get('/payment/detail', function () {
    return view('payment_detail');
});
// end user

//admin
Route::get('/admin/login', function () {
    return view('auth/login');
});
Route::get('/admin/history/login', function () {
    return view('admin/historylogin');
});
Route::get('/admin/appointment', function () {
    return view('admin/appointment');
});
Route::get('/admin/payment', function () {
    return view('admin/payment');
});
//end admin

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
