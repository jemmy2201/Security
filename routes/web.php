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
// end user

//admin
Route::get('/admin/login', function () {
    return view('auth/login');
});

Route::get('/admin/appointment', function () {
    return view('admin/appointment');
});
Route::get('/admin/payment', function () {
    return view('admin/payment');
});
//end admin

Auth::routes();
// User
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/personal/particular','HomeController@personaldata')->name('personal.particular');
Route::post('/submission', 'HomeController@submission')->name('submission');
Route::post('/book/appointment', 'HomeController@book_appointment')->name('book.appointment');
Route::post('/save/book/appointment', 'HomeController@View_payment')->name('save.book.appointment');
Route::post('/save/payment', 'HomeController@Createpayment')->name('save.payment');
// End User

// Admin
Route::get('/admin/history/login', function () {
    return view('admin/historylogin');
});
Route::get('/admin/price', 'AdminController@price');
// End Admin
Route::prefix('ajax')->group(function () {
    Route::get('/cek/data/from', 'AjaxController@cek_data_from');
    Route::post('/cek/data/limit/schedule', 'AjaxController@cek_limit_schedule');
    Route::post('/data/price/view', 'AjaxController@data_price')->name('admin.data_price');
    Route::post('/insert/price', 'AjaxController@insert_price')->name('admin.insert.price');
    Route::post('/update/price', 'AjaxController@update_price')->name('admin.update.price');
});
