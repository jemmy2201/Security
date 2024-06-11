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
Route::middleware(['maintenance'])->group(function () {
    // user
    Route::get('/', function () {
        return view('login');
    });
    Route::get('/login/dummy/{type}', 'SingpassController@dummy_login');
    Route::get('/login/dummy/{type}/passlogin', 'SingpassController@dummy_login');
});



    Route::get('/qrcode', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Auth::logout();
    //    return view('information');
        return view('login');
    })->name('qrcode');

    // untuk muncukan information
    //Route::get('/login/qrcode', function () {
    //    Artisan::call('cache:clear');
    //    Artisan::call('view:clear');
    //    Auth::logout();
    //    return view('login');
    //});
    // end untuk muncukan information

    Route::get('/relogin', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Auth::logout();
    //    return view('information');
        return view('login');
    })->name('relogin');

    // singpass
    Route::get('/afterlogin', 'SingpassController@login');
    //Uat
    Route::get('/oauth2/uat_jwks', 'SingpassController@jwks');
    //ENd Uat
    //Prod
    Route::get('/oauth2/jwks', 'SingpassController@jwks');
    //Prod
    Route::get('/private/ec/jwks', 'SingpassController@private_key_ec');

    Route::get('/private/sig/jwks', 'SingpassController@private_key_sig');
    Route::get('/public/sig/jwks', 'SingpassController@public_key_sig');
    Route::get('/public/private/sig/jwks', 'SingpassController@public_private_key_sig');
    // End singpass

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
    Route::get('/landing_page', 'HomeController@landing_page')->name('landing_page');
    Route::post('/personal/particular','HomeController@personaldata')->name('personal.particular');
    Route::post('/submission', 'HomeController@submission')->name('submission');
    Route::get('/submission', 'HomeController@getsubmission');
    Route::post('/declare/submission', 'HomeController@declare_submission')->name('declare.submission');
    Route::post('/book/appointment', 'HomeController@book_appointment')->name('book.appointment');
    Route::post('/payment', 'HomeController@View_payment')->name('save.book.appointment');
    Route::get('/get_payment/{card}/{valid_resubmission}/{view_date}/{limit_schedule_id}', 'HomeController@get_View_payment');
    Route::post('/save/payment', 'HomeController@Createpayment')->name('save.payment');
    Route::post('/generate/Pdf', 'HomeController@GeneratePdf')->name('generate.pdf');
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
    Route::get('/view/course/{id}', 'HomeController@view_course')->name('view.course');
    Route::get('/invoice/print/pdf/{id}', 'HomeController@print_pdf');
    // end get history continous

    Route::get('/cancel/payment/{app_type}/{card}', 'HomeController@cancel_payment');
    Route::get('/use_ntuc', 'HomeController@use_ntuc');
    // End User

    // Super User
    Route::get('/super/user/landing_page', 'Super_user\SuperUserController@landing_page')->name('super_user.landing_page');
    Route::post('/super/user/landing_page', 'Super_user\SuperUserController@landing_page')->name('super_user.landing_page');
    Route::post('/super/user/personal/particular','Super_user\SuperUserController@personaldata')->name('super_user.personal.particular');
    Route::post('/super/super/user/submission', 'Super_user\SuperUserController@submission')->name('super_user.submission');
    Route::get('/super/user/submission', 'Super_user\SuperUserController@getsubmission');
    Route::post('/super/user/declare/submission', 'Super_user\SuperUserController@declare_submission')->name('super_user.declare.submission');
    Route::post('/super/user/book/appointment', 'Super_user\SuperUserController@book_appointment')->name('super_user.book.appointment');
    Route::post('/super/user/payment', 'Super_user\SuperUserController@View_payment')->name('super_user.save.book.appointment');
    Route::get('/super/user/get_payment/{card}/{valid_resubmission}/{view_date}/{limit_schedule_id}', 'Super_user\SuperUserController@get_View_payment');
    Route::post('/super/user/save/payment', 'Super_user\SuperUserController@Createpayment')->name('super_user.save.payment');
    Route::get('/super/user/after/payment/{id}', 'Super_user\SuperUserController@after_payment')->name('super_user.after.payment');

    Route::get('/super/user/personal/particular','Super_user\SuperUserController@personaldata')->name('super_user.personal.particular');
    Route::get('/super/user/back/personal/particular/{app_type}/{card}/{status}','Super_user\SuperUserController@backpersonaldata');
    Route::get('/super/user/back/personal/particular/{app_type}/{card}','Super_user\SuperUserController@backpersonaldata');
    Route::get('/super/user/back/submission/{app_type}/{card}/{Cgrades}','Super_user\SuperUserController@backsubmission');
    Route::post('/super/user/replacement/personal/particular', 'Super_user\SuperUserController@replacement_personaldata')->name('super_user.replacement.personal.particular');
    Route::post('/super/user/renewal/personal/particular', 'Super_user\SuperUserController@renewal_personaldata');

    // Check Payment
    Route::post('/super/user/check_payment', 'Super_user\SuperUserController@check_payment');
    // End Check Payment
    // create number transaction
    Route::post('/super/user/create_receiptno', 'Super_user\SuperUserController@create_receiptno');
    // end create number transaction
    // save data barcode paynow
    Route::post('/super/user/save_barcode_paynow', 'Super_user\SuperUserController@save_barcode_paynow');
    // end save data barcode paynow
    // get history continous
    Route::get('/super/user/history/book/appointment/{app_type}/{card}', 'Super_user\SuperUserController@HistoryBookAppointment');
    Route::get('/super/user/history/book/payment/{app_type}/{card}', 'Super_user\SuperUserController@HistoryViewPayment');
    Route::get('/super/user/personal/particular/{app_type}/{card}/{status}', 'Super_user\SuperUserController@resubmission');
    Route::get('/super/user/draft/{app_type}/{card}', 'Super_user\SuperUserController@backDraft');
    Route::get('/super/user/save_draft/{app_type}/{card}/{array_grade}/{logout_save_draft}', 'Super_user\SuperUserController@savedraft');
    Route::get('/super/user/view/course/{id}', 'Super_user\SuperUserController@view_course')->name('view.course');
    Route::get('/super/user/invoice/print/pdf/{id}', 'Super_user\SuperUserController@print_pdf');
    // end get history continous

    //Update SO
    Route::get('/super/user/update_so', 'HomeController@ui_update_so')->name('super_user.update.so');
    Route::post('/super/user/action/update_so', 'HomeController@action_update_so')->name('super_user.action.update_so');
    //End Update SO

    Route::get('/super/user/cancel/payment/{app_type}/{card}', 'Super_user\SuperUserController@cancel_payment');
    // Check booking schedule
    Route::post('/super/user/check/booking/schedule', 'Super_user\SuperUserController@check_booking_schedule');
    // End booking schedule
    Route::prefix('ajax')->group(function () {
        // check file page home
        Route::post('/check/file/home', 'Super_user\AjaxSuperUserController@check_file_home')->name('check_file_home');
        // End check file page home
        Route::get('super/user/cek/data/from', 'Super_user\AjaxSuperUserController@cek_data_from');
        Route::get('super/user/cek/card/type', 'Super_user\AjaxSuperUserController@cek_card_type');
        Route::post('super/user/cek/data/limit/schedule', 'Super_user\AjaxSuperUserController@cek_limit_schedule');
        Route::post('super/user/cek/data/schedule', 'Super_user\AjaxSuperUserController@cek_data_schedule');
        Route::get('super/user/download/excel/schedule', 'Super_user\AjaxSuperUserController@schedule');
        Route::get('super/user/download/excel/template/grade', 'Super_user\AjaxSuperUserController@download_template_grade');
        Route::post('super/user/delete/process', 'Super_user\AjaxSuperUserController@delete_process')->name('super.users.delete.process');
        Route::post('super/user/sent/activation/phone', 'Super_user\AjaxSuperUserController@sent_activation_phone');
        Route::post('super/user/check/activation', 'Super_user\AjaxSuperUserController@check_activation');
        Route::post('super/user/check/passID', 'Super_user\AjaxSuperUserController@check_passID');
        // Check Count booking
        Route::post('/super/user/check/count/booking', 'Super_user\AjaxSuperUserController@check_count_booking');
        Route::post('/super/user/check/expired/cards', 'Super_user\AjaxSuperUserController@checkexpiredcard');

        // End Check Count booking
    });


    // End Super User


    // SO Query
    Route::get('/SOQuery/IDQuery/{passid}', 'SoQueryController@soquery');
    Route::get('/soqUERY/idqUERY/{passid}', 'SoQueryController@soquery');
    // End SO Query
    // save data barcode paynow
    Route::post('/save_barcode_paynow', 'HomeController@save_barcode_paynow');
    // end save data barcode paynow
    // Check Payment
    Route::post('/check_payment', 'HomeController@check_payment');
    // End Check Payment

    // Check booking schedule
    Route::post('/check/booking/schedule', 'HomeController@check_booking_schedule');
    // End booking schedule

    // create number transaction
    Route::post('/create_receiptno', 'HomeController@create_receiptno');
    // end create number transaction
    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('/history/login', 'AdminController@historylogin');
        Route::get('/security/employees', 'AdminController@security_employees');
        Route::get('appointment', 'AdminController@appointment');
        Route::get('upgrade/grade', 'AdminController@upgrade_grade');
        Route::get('upload/payment', 'AdminController@upload_payment');
        Route::get('limit/schedule', 'AdminController@limit_schedule');
        Route::get('holiday/table', 'AdminController@holiday_table');
        Route::get('/gst', 'AdminController@gst');
        Route::get('/price', 'AdminController@price');
        Route::get('/course', 'AdminController@course');
        Route::get('/change/password', 'AdminController@change_pass');
    });
    // End Admin
    Route::prefix('ajax')->group(function () {
        // check file page home
        Route::post('/check/file/home', 'AjaxController@check_file_home')->name('check_file_home');
        // End check file page home
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
        Route::post('/upload/payment', 'AjaxController@upload_payment')->name('admin.upload.payment');
        Route::post('/upload/import/excel/grades', 'AjaxController@upload_import_excel_grade')->name('admin.upload.import.grade');
        Route::post('/insert/course', 'AjaxController@add_course')->name('admin.insert.course');
        Route::post('/update/course', 'AjaxController@update_course')->name('admin.update.course');
        Route::post('/delete/course', 'AjaxController@delete_course')->name('admin.delete.course');
        Route::get('/download/excel/schedule', 'AjaxController@schedule');
        Route::get('/download/excel/template/grade', 'AjaxController@download_template_grade');
        Route::post('/restoring/table', 'AjaxController@restoring_table')->name('admin.restoring.table');
        Route::post('/delete/process', 'AjaxController@delete_process')->name('users.delete.process');
        Route::post('/sent/activation/phone', 'AjaxController@sent_activation_phone');
        Route::post('/check/activation', 'AjaxController@check_activation');
        Route::post('/check/passID', 'AjaxController@check_passID');
        Route::post('/check/expired/card', 'AjaxController@check_expired_card')->name('check.expired.card');

        //status payment
        Route::post('/check/status/payment', 'AjaxController@StatusPayment');
        //end status payment

        // Check Count booking
        Route::post('/user/check/count/booking', 'AjaxController@check_count_booking');
        // End Check Count booking
        Route::post('/check/expired/cards', 'AjaxController@checkexpiredcard');

    });

    //Update SO
    Route::get('/update_so', 'HomeController@ui_update_so')->name('update.so');
    Route::post('/action/update_so', 'HomeController@action_update_so')->name('action.update_so');
    //End Update SO
