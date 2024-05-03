<?php
define('passlogin', 'passlogin');

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

//define('draft', 0);
//define('submitted', 1);
//define('processing', 2);
//define('id_card_ready_for_collection', 3);
//define('resubmission', 4);
//define('Resubmitted', 5);
//define('completed', "X");

define('draft', 0);
define('processing', 1);
define('ready_for_id_card_printing', 2);
define('id_card_ready_for_collection', 3);
define('resubmission', 4);
define('Resubmitted', 5);
define('completed', 6);


define('txt_draft', "Draft");
define('txt_submitted', "Submitted (Payment done)");
define('txt_processing', "Processing");
define('txt_ready_for_id_card_printing', "Ready For ID card printing");
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
define('office', 2);
define('staff', 3);

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
define('C4', 9);
// end payment

// Union member
define('display', 0);
define('not_display', 1);
// End Union member
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

define('half_5', "12:30");
define('half_1', "13:30");
define('half_2', "14:30");
define('half_3', "15:30");
define('half_4', "16:30");

//define('cek_pathname', "/qrcode");
define('cek_pathname', "/login/qrcode");
define('cek_pathname_logout', "/submission");
define('url_relogin', "/relogin");
define('login_dummy', "/login/dummy/1");
define('default_alter_login', "home");
define('page_update_so', "update.so");
define('default_alter_term_use', "landing_page");
define('default_home', "qrcode");
define('default_landing', "landing");
define('landing_page_passID', "super_user.landing_page");
define('after_payment', "after.payment");
define('view_course', "view.course");
define('default_submission', "submission");
//define('view_course', "App\Http\Controllers\HomeController@view_course{\"mode\":\"full\",\"isActive\":false}");

define('date_last', "31");

define('work_permit_pass', "G");
define('employment_pass', "F");
define('RemoveExpiredCard', "R");
define('NotExpiredCard', "N");
define('ExpiredCard', "Y");

define('one_mb', "1000000");
define('five_mb', "5000000");

//Enets

// Local Host
define('ApiurlEnetsLocal', "https://uat2.enets.sg/GW2/TxnReqListenerToHost");
define('secretKeyEnetsLocal', "b747c80c-7f3d-481b-9f94-f42e0aff8ffb");
define('secretIDEnetsLocal', "a2ff775e-5a06-419b-bc8b-58c1087ce128");
define('netsMidLocal', "UMID_837852000");
define('Merchant_server_IP_AddressLocal', "127.0.0.1");
define('s2sTxnEndURLLocal', "http://localhost:8000/api/s2sTxnEndURL");
define('b2sTxnEndURLLocal', "http://localhost:8000/api/b2sTxnEndURL");
// End LOcal Host

// Uat
define('ApiurlEnetsUat', "https://uat2.enets.sg/GW2/TxnReqListenerToHost");
define('secretKeyEnetsUat', "b747c80c-7f3d-481b-9f94-f42e0aff8ffb");
define('secretIDEnetsUat', "a2ff775e-5a06-419b-bc8b-58c1087ce128");
define('netsMidUat', "UMID_837852000");
define('Merchant_server_IP_AddressUat', "127.0.0.1");
define('s2sTxnEndURLUat', "https://www.idx-id2021.com/api/s2sTxnEndURL");
define('b2sTxnEndURLUat', "https://www.idx-id2021.com/api/b2sTxnEndURL");

//define('ApiurlEnetsUat', "https://www2.enets.sg/GW2/TxnReqListenerToHost");
//define('secretKeyEnetsUat', "43074426-5e54-41cf-8195-62b8d93c53da");
//define('secretIDEnetsUat', "6b06f0b3-dd78-4e5e-9efd-cb12ac488537");
//define('netsMidUat', "UMID_828259000");
//define('Merchant_server_IP_AddressUat', "127.0.0.1");
//define('s2sTxnEndURLUat', "https://www.idx-id2021.com/api/s2sTxnEndURL");
//define('b2sTxnEndURLUat', "https://www.idx-id2021.com/api/b2sTxnEndURL");
// End Uat

//Prod
define('ApiurlEnetsProd', "https://www2.enets.sg/GW2/TxnReqListenerToHost");
define('secretKeyEnetsProd', "43074426-5e54-41cf-8195-62b8d93c53da");
define('secretIDEnetsProd', "6b06f0b3-dd78-4e5e-9efd-cb12ac488537");
define('netsMidProd', "UMID_828259000");
define('Merchant_server_IP_AddressProd', "127.0.0.1");
define('s2sTxnEndURLProd', "https://www.iduse.org.sg/api/s2sTxnEndURL");
define('b2sTxnEndURLProd', "https://www.iduse.org.sg/api/b2sTxnEndURL");
//define('b2sTxnEndURL', "http://localhost:8000/api/b2sTxnEndURL");
//End Prod


//End Enets

//Env singapass

define('URLUat', "https://www.idx-id2021.com");
define('URLProd', "https://www.iduse.org.sg");
define('LocalHost', "http://localhost:8000");



//Uat

define('authApiUrlUat', "https://stg-id.singpass.gov.sg/token");
define('auth_req_idUrlUat', "https://stg-id.singpass.gov.sg/bc-auth");
define('urlsigUat', "http://www.idx-id2021.com/private/sig/jwks");
define('urlecUat', "http://www.idx-id2021.com/private/ec/jwks");
define('urlpublicsigUat', "http//www.idx-id2021.com/public/sig/jwks");
define('urlprivatecsigUat', "http://www.idx-id2021.com/private/sig/jwks");
define('urlpublicprivatecsigUat', "http://www.idx-id2021.com/public/private/sig/jwks");
define('authApiUrlSingpassconfigurationUat', "https://stg-id.singpass.gov.sg/.well-known/openid-configuration");
define('clientIdSinpassUat', "99gEBb5Bo6stbYJ9jVbmrCFyBZhbeU4I");
define('clientIdSecretUat', "99gEBb5Bo6stbYJ9jVbmrCFyBZhbeU4I");
define('redirectUrlSingpassUat', "https://www.idx-id2021.com/afterlogin");
//define('redirectUrlSingpassCurlUat', "https%3A%2F%2Fwww.idx-id2021.com%2Fafterlogin");
define('redirectUrlSingpassCurlUat', "https://www.idx-id2021.com/afterlogin");
define('attributesSingPassUat', "attributes=name,email,uinfin,passportexpirydate,passportnumber,homeno,mobileno");
define('hostUat', "https://stg-id.singpass.gov.sg");
define('audUat', "https://stg-id.singpass.gov.sg");

//End Uat

// Prod
define('authApiUrlProd', "https://id.singpass.gov.sg/token");
define('auth_req_idUrlProd', "https://id.singpass.gov.sg/bc-auth");
define('urlsigProd', "https://www.iduse.org.sg/private/sig/jwks");
define('urlpublicsigProd', "https://www.iduse.org.sg/public/sig/jwks");
define('urlprivatecsigProd', "https://www.iduse.org.sg/private/sig/jwks");
define('urlpublicprivatecsigProd', "https://www.iduse.org.sg/public/private/sig/jwks");
define('urlecProd', "https://www.iduse.org.sg/private/ec/jwks");
define('authApiUrlSingpassconfigurationProd', "https://id.singpass.gov.sg/.well-known/openid-configuration");
define('clientIdSinpassProd', "NaetSKDCoBD7BmWapXha61878SNkP3zF");
define('clientIdSecretProd', "NaetSKDCoBD7BmWapXha61878SNkP3zF");
define('redirectUrlSingpassProd', "https://www.iduse.org.sg/afterlogin");
define('redirectUrlSingpassCurlProd', "https://www.iduse.org.sg/afterlogin");
define('attributesSingPassProd', "attributes=name,email,uinfin,passportexpirydate,passportnumber,homeno,mobileno");
define('hostProd', "https://id.singpass.gov.sg");
define('audProd', "https://id.singpass.gov.sg");
// End Prod

//define('url_api_private_key_jwe', "https://www.idx-id2021.com/api/jwe/decrypted");
define('url_api_private_key_jwe', "http://localhost:8000/api/jwe/decrypted");


// Paynow
define('uen', "S78TU0494DIDC");
// End Paynow

define('less_than_days', "+7");
define('thanks_payment', "Thank you for the payment");
//define('refNumber', "");
define('refNumber', "Union Of Security Employees");

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

// Size
define('desktop', 1);
define('phone', 2);
// End Size

// month
define('december', 11);
define('januari', 0);
// End month

define('zero', 0);
define('default_email', "email");

define('n_card_issue', "N");
define('R_card_issue', "R");
define('value_card_issue1', "Kindly contact Union Of Security Employees for further assistance.");
define('value_card_issue2', "Contact details as shown on the top of this page.");
define('value_SO_IDQuery1', "Pass ID not found.");
define('value_SO_IDQuery2', "if you just collected your ID card 3 days earlier,");
define('value_SO_IDQuery3', "please re-visit the web-site via QR code again.");
define('value_expired_card1', "Your ID card's expiry date has expired.");
define('value_expired_card2', "Renew your PLRD SO/PI licence @ Go Business Singapore website - https://www.gobusiness.gov.sg");
//define('value_not_found1', "Record not found.");
//define('value_not_found1', "Record not available yet.");
//define('value_not_found1', "Record Not Available Yet.");
define('value_not_found1', "Your Card Licence Not Found / Expired.");
define('value_not_found2', "Please contact Union Of Security Employees for  further assistance.");
define('value_not_found3', "1) You have not completed the PLRD online new/renewal application at https//licence1.business.gov.sg");
define('value_not_found4', "2) Your approved data from PLRD may take 48 - 72 hours to be updated into USE's ID card portal");
define('value_not_found5', "1) You have requested a replacement for your ID card when your ID card will be expiring soon.");
define('value_not_found6', "2) You need to contact USE for confirmation.");
define('value_not_found7', "Unable To Apply ID Card");
define('value_not_found8', "PLRD contact detail Email : spf_licensing_feedback@gov.sg or telephone: +65 6853 0000");
define('value_not_found9', "2) You need to contact PLRD directly.");
define('value_not_found10', "1) Your PLRD Licence is not Active.");

define('type_error_so_query', 1);

define('phone_general_office', "+65 6381 9150");
define('phone_CSC', "+65 6291 5145 (CSC)");
define('email', "use-idcard@ntuc.org.sg");

define('Senior_Security_Officer', "SSO");
define('Security_Supervisor', "SS");
define('Senior_Security_Supervisor', "SSS");
define('Chief_Security_Officer', "CSO");

// Home
define('check_name_file_home', "USE_Change.txt");
define('file_wrong', "File Wrong");
define('file_contents', "useofsecurityemployees2022");
define('wrong_file_contents', "Wrong Value");
define('success_check', "success");
// End Home

// Remove Temp page Home
//
define('time_off_temp_page_home', "2022-05-01 22:00:00");

// Remove Temp page Home

// counting years time schedule
define('Oneyears', 1);
define('Twoyears', 2);
define('Threeyears', 3);

define('Maret', 2);
define('April', 3);

// End counting years time schedule

// version chorem
define('version_chrome', 102);


// end version chorem
define('login', 1);

//define('expired_less_3month', "Expires less than 3 month");
define('expired_less_3month', "Your ID card will be expiring soon");

define('unable_to_apply_id_card', "Your ID card will be expiring soon");

define('full_booking', 'No more available bookings for the selected slot');
define('count_booking', 40);
