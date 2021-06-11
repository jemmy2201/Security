<?php
//application type
define('news', 0);
define('replacement', 1);
define('renewal', 2);
//End application type

//card
define('so_app', 1);
define('avso_app', 2);
define('pi_app', 3);
//End card

//SO APP
define('so', 1);
define('sso', 2);
define('sss', 3);
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
define('completed', 5);

// end status app

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
define('nnnn', "0000");
// end invoice
