<?php
//application type
define('news', 1);
define('replacement', 2);
define('renewal', 3);
//End application type

//card
define('so_app', 1);
define('avso_app', 2);
define('pi_app', 3);
//End card

//SO APP
define('so', 1);
define('sso', 2);
define('ss', 3);
define('sss', 4);
define('cso', 5);
//End SO APP

// payment method
define('paynow', 1);
define('enets', 2);
define('visa', 3);
define('mastercard', 4);
// End payment method

// type login
define('barcode', 0);
define('non_barcode', 1);
// end type login

// status app

//define('submission', 1);
//define('book_appointment', 2);
//define('payment', 3);

define('draft', 0);
define('submitted', 1);
define('processing', 2);
define('id_card_ready_for_collection', 3);
define('resubmission', 4);
define('Resubmitted', 5);
define('completed', "X");

define('txt_draft', "Draft");
define('txt_submitted', "Submitted (Payment done)");
define('txt_processing', "Processing");
define('txt_id_card_ready_for_collection', "ID Card Ready for Collection");
define('txt_resubmission', "Resubmission");
define('txt_Resubmitted', "Resubmitted");
define('txt_completed', "Completed (Card Collected)");
// end status app

//Status Draft
define('draft_book_appointment', 0);
define('draft_payment', 1);
//End Status Draft

define('time08', "08:00");
define('time09', "09:00");
define('time10', "10:00");
define('time11', "11:00");
define('time12', "12:00");
define('time13', "13:00");
define('time14', "14:00");
define('time15', "15:00");
define('time16', "16:00");
define('time17', "17:00");

define('admin', 1);

// type login
define('update', 0);
define('save', 1);
// end type login

// reponse ajax
define('data_already_exists', "208");
// end reponse ajax

// status limit schedule
define('not_aktif', 0);
define('aktif', 1);
// end status limit schedule

// status payment
define('unpaid', 0);
define('paid', 1);
// end payment

// response limit schedule
define('start_empty', 101);
define('end_empty', 102);
define('data_has_been_used_in_the_booking_schedule', 103);
// end response limit schedule

// response update password
define('not_find_pass', 101);
// end response update password

//default password
define('default_pass', "Spcp1111");
//End default password

// Delete data if not payment and wait 3 month for delete data
define('three_month', 3);
// End Delete data if not payment and wait 3 month for delete data

// bsoc
define('S01', 1);
define('S02', 2);
define('S03', 3);
// end bsoc

// ssoc
define('SS01', 4);
define('SS02', 5);
// end ssoc

// sssc
define('SSS1', 6);
define('SSS2', 7);
define('SSS3', 8);
// end sssc

// default bsoc,ssoc,ssc
define('default_bsoc_ssoc_ssc', '000000');
// end default bsoc,ssoc,ssc

// delete soft
define('delete_soft', 1);
// end delete soft

// invoice
define('nnnn', "00000");
// end invoice


define('full', 1);
define('half', 2);

define('dummy', 1);

define('half_1', "13:00");
define('half_2', "14:00");
define('half_3', "15:00");
define('half_4', "18:00");

define('cek_pathname', "/qrcode");
define('login_dummy', "/login/dummy/1");
define('default_alter_login', "home");
define('default_submission', "submission");
define('view_course', "App\Http\Controllers\HomeController@view_course{\"mode\":\"full\",\"isActive\":false}");

define('date_last', "31");

define('work_permit_pass', "G");
define('employment_pass', "F");

define('one_mb', "1000000");

//Enets
define('ApiurlEnets', "https://uat2.enets.sg/GW2/TxnReqListenerToHost");
define('secretKeyEnets', "b747c80c-7f3d-481b-9f94-f42e0aff8ffb");
define('secretIDEnets', "a2ff775e-5a06-419b-bc8b-58c1087ce128");
define('netsMid', "UMID_837852000");
define('Merchant_server_IP_Address', "127.0.0.1");
define('s2sTxnEndURL', "http://127.0.0.1");
define('b2sTxnEndURL', "https://www.idx-id2021.com/b2sTxnEndURL/");
//End Enets

//Env singapass
define('authApiUrl', "https://stg-id.singpass.gov.sg/token");
define('urlsig', "https://www.idx-id2021.com/private/sig/jwks");
define('urlec', "http://www.idx-id2021.com/private/ec/jwks");
define('authApiUrlSingpassconfiguration', "https://stg-id.singpass.gov.sg/.well-known/openid-configuration");
define('clientIdSinpass', "99gEBb5Bo6stbYJ9jVbmrCFyBZhbeU4I");
define('clientIdSecret', "99gEBb5Bo6stbYJ9jVbmrCFyBZhbeU4I");
define('redirectUrlSingpass', "https://www.idx-id2021.com/afterlogin");
define('redirectUrlSingpassCurl', "https%3A%2F%2Fwww.idx-id2021.com%2Fafterlogin");
//define('redirectUrlSingpass', "https://www.idx-id2021.com/oauth2/uat_jwks");
define('attributesSingPass', "attributes=name,email,uinfin,passportexpirydate,passportnumber,homeno,mobileno");

// Paynow
define('uen', "S78TU0494DIDC");
// End Paynow

define('less_than_days', "+7");
define('thanks_payment', "Thank you for the payment");

define('fail', 1);
define('success', 0);


//End Env singapass

// activation phone
define('failed', 0);
define('succes', 1);
define('already_used', 2);

define('not_number_singapore', 2);
define('wrong_format_number', 3);
define('same_number_phone', 4);
// end activation phone
