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

Route::get('/', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
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
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
