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
Route::post('/payment', 'HomeController@View_payment')->name('save.book.appointment');
Route::post('/save/payment', 'HomeController@Createpayment')->name('save.payment');
// End User

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/history/login', 'AdminController@historylogin');
    Route::get('/security/employees', 'AdminController@security_employees');
    Route::get('appointment', 'AdminController@appointment');
    Route::get('limit/schedule', 'AdminController@limit_schedule');
    Route::get('/price', 'AdminController@price');
    Route::get('/gst', 'AdminController@gst');

});
// End Admin
Route::prefix('ajax')->group(function () {
    Route::get('/cek/data/from', 'AjaxController@cek_data_from');
    Route::post('/cek/data/limit/schedule', 'AjaxController@cek_limit_schedule');
    Route::post('/cek/data/schedule', 'AjaxController@cek_data_schedule');
    Route::post('/data/history/login', 'AjaxController@history_login')->name('admin.history.login');
    Route::post('/data/security/employees', 'AjaxController@security_employees')->name('admin.security.employees');
    Route::post('/data/price/view', 'AjaxController@data_price')->name('admin.data_price');
    Route::post('/data/gst', 'AjaxController@data_gst')->name('admin.data.gst');
    Route::post('/create/gst', 'AjaxController@create_gst')->name('admin.create.gst');
    Route::post('/data/limit/schedule', 'AjaxController@data_limit_shedule')->name('admin.data_limit_shedule');
    Route::post('/insert/limit_schedule', 'AjaxController@insert_limit_schedule')->name('admin.insert.limit_schedule');
    Route::post('/update/amount/limit_schedule', 'AjaxController@update_limit_schedule')->name('admin.update.limit_schedule');
    Route::post('/insert/price', 'AjaxController@insert_price')->name('admin.insert.price');
    Route::post('/update/price', 'AjaxController@update_price')->name('admin.update.price');
});
