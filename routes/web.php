<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/login/dummy/{type}', 'SingpassController@dummy_login');

Route::get('/qrcode', function () {
    Auth::logout();
    return view('login');
})->name('qrcode');

// Enets
Route::get('/s2sTxnEndURL', 'EnetsController@s2sTxnEndURL');
Route::get('/b2sTxnEndURL/', 'HomeController@b2sTxnEndURL');

Route::post('/enets/frontend_response', 'EnetsController@frontend_response');
Route::post('/enets/backend_response', 'EnetsController@backend_response');

// End Enets

Route::get('/afterlogin', 'SingpassController@login');
Route::get('/oauth2/uat_jwks', 'SingpassController@jwks');
Route::get('/private/ec/jwks', 'SingpassController@private_key_ec');
Route::get('/private/sig/jwks', 'SingpassController@private_key_sig');

// end user

//admin
//Route::get('/admin/login', function () {
//    return view('auth/login');
//});


Route::get('/admin/payment', function () {
    return view('admin/payment');
});
//end admin

Auth::routes();
// User
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/personal/particular','HomeController@personaldata')->name('personal.particular');
Route::post('/submission', 'HomeController@submission')->name('submission');
Route::get('/submission', 'HomeController@getsubmission');
Route::post('/declare/submission', 'HomeController@declare_submission')->name('declare.submission');
Route::post('/book/appointment', 'HomeController@book_appointment')->name('book.appointment');
Route::post('/payment', 'HomeController@View_payment')->name('save.book.appointment');
Route::post('/save/payment', 'HomeController@Createpayment')->name('save.payment');
Route::get('/after/payment/{id}', 'HomeController@after_payment')->name('after.payment');

Route::get('/personal/particular','HomeController@personaldata')->name('personal.particular');
Route::get('/back/personal/particular/{app_type}/{card}/{status}','HomeController@backpersonaldata');
Route::get('/back/personal/particular/{app_type}/{card}','HomeController@backpersonaldata');
Route::get('/back/submission/{app_type}/{card}/{Cgrades}','HomeController@backsubmission');
//Route::get('/replacement/personal/particular/{id}', 'HomeController@replacement_personaldata');
Route::post('/replacement/personal/particular', 'HomeController@replacement_personaldata')->name('replacement.personal.particular');
//Route::get('/renewal/personal/particular/{id}', 'HomeController@renewal_personaldata');
Route::post('/renewal/personal/particular', 'HomeController@renewal_personaldata');

// get history continous
Route::get('/history/book/appointment/{app_type}/{card}', 'HomeController@HistoryBookAppointment');
Route::get('/history/book/payment/{app_type}/{card}', 'HomeController@HistoryViewPayment');
Route::get('/personal/particular/{app_type}/{card}/{status}', 'HomeController@resubmission');
Route::get('/draft/{app_type}/{card}', 'HomeController@backDraft');
Route::get('/save_draft/{app_type}/{card}/{array_grade}/{logout_save_draft}', 'HomeController@savedraft');
Route::get('/view/course/{id}', 'HomeController@view_course');
Route::get('/invoice/print/pdf/{id}', 'HomeController@print_pdf');
// end get history continous

Route::get('/cancel/payment/{app_type}/{card}', 'HomeController@cancel_payment');

// End User

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/history/login', 'AdminController@historylogin');
    Route::get('/security/employees', 'AdminController@security_employees');
    Route::get('appointment', 'AdminController@appointment');
    Route::get('upgrade/grade', 'AdminController@upgrade_grade');
    Route::get('limit/schedule', 'AdminController@limit_schedule');
    Route::get('holiday/table', 'AdminController@holiday_table');
    Route::get('/gst', 'AdminController@gst');
    Route::get('/price', 'AdminController@price');
    Route::get('/course', 'AdminController@course');
    Route::get('/change/password', 'AdminController@change_pass');
});
// End Admin
Route::prefix('ajax')->group(function () {
    Route::get('/cek/data/from', 'AjaxController@cek_data_from');
    Route::get('/cek/card/type', 'AjaxController@cek_card_type');
    Route::post('/cek/data/limit/schedule', 'AjaxController@cek_limit_schedule');
    Route::post('/cek/data/schedule', 'AjaxController@cek_data_schedule');
    Route::post('/data/history/login', 'AjaxController@history_login')->name('admin.history.login');
    Route::post('/data/security/employees', 'AjaxController@security_employees')->name('admin.security.employees');
    Route::post('/data/price/view', 'AjaxController@data_price')->name('admin.data_price');
    Route::post('/data/holiday/view', 'AjaxController@data_holiday')->name('admin.data.holiday');
    Route::post('/data/grade/view', 'AjaxController@data_grade')->name('admin.data.upgrade');
    Route::post('/data/course/view', 'AjaxController@data_course')->name('admin.data.course');
    Route::post('/data/gst', 'AjaxController@data_gst')->name('admin.data.gst');
    Route::post('/create/gst', 'AjaxController@create_gst')->name('admin.create.gst');
    Route::post('/data/limit/schedule', 'AjaxController@data_limit_shedule')->name('admin.data_limit_shedule');
    Route::post('/insert/limit_schedule', 'AjaxController@insert_limit_schedule')->name('admin.insert.limit_schedule');
    Route::post('/update/amount/limit_schedule', 'AjaxController@update_limit_schedule')->name('admin.update.limit_schedule');
    Route::post('/insert/price', 'AjaxController@insert_price')->name('admin.insert.price');
    Route::post('/update/price', 'AjaxController@update_price')->name('admin.update.price');
    Route::post('/insert/holiday', 'AjaxController@insert_holiday')->name('admin.insert.holiday');
    Route::post('/update/holiday', 'AjaxController@update_holiday')->name('admin.update.holiday');
    Route::post('/delete/holiday', 'AjaxController@delete_holiday')->name('admin.delete.holiday');
    Route::post('/change/password', 'AjaxController@updatePassword')->name('admin.change.password');
    Route::post('/upload/excel/grade', 'AjaxController@upload_excel_grade')->name('admin.upload.grade');
    Route::post('/insert/course', 'AjaxController@add_course')->name('admin.insert.course');
    Route::post('/update/course', 'AjaxController@update_course')->name('admin.update.course');
    Route::post('/delete/course', 'AjaxController@delete_course')->name('admin.delete.course');
    Route::get('/download/excel/schedule', 'AjaxController@schedule');
    Route::get('/download/excel/template/grade', 'AjaxController@download_template_grade');
    Route::post('/restoring/table', 'AjaxController@restoring_table')->name('admin.restoring.table');
    Route::post('/delete/process', 'AjaxController@delete_process')->name('users.delete.process');
    Route::post('/sent/activation/phone', 'AjaxController@sent_activation_phone');
    Route::post('/check/activation', 'AjaxController@check_activation');
});
