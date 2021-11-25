<?php

namespace App\Http\Controllers;

use App\booking_schedule;
use App\t_grade;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Route;

class EnetsController extends Controller
{
    public function s2sTxnEndURL(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function b2sTxnEndURL(Request $request)
    {
        $jsonmsg = urldecode($request->message);
        $jsonarr = json_decode($jsonmsg);
        if (!empty($jsonarr->msg) && $jsonarr->msg->netsTxnStatus == success) {
            $data_person = json_decode($jsonarr->msg->b2sTxnEndURLParam);
            $BookingScheduleAppointment = booking_schedule::where(['nric' => $data_person->nric, 'card_id' => $data_person->card])
                ->update([
                    'gst_id' => $data_person->grade_id,
                    'trans_date' => date('d/m/Y H:i:s'),
                    'paymentby' => "Enets",
                    'status_payment' => paid,
                    'grand_total' => $data_person->grand_total,
                    'status_app' => submitted,
                    'transaction_amount_id' => $data_person->transaction_amount_id,
                    'netstxnref' => $jsonarr->msg->netsTxnRef,
                    'txnrand' => $jsonarr->msg->txnRand,
                ]);

            $request->merge(['app_type' => $data_person->app_type, 'thank_payment' => true,'card' => $data_person->card,'router_name' => Route::getCurrentRoute()->getActionName()]);
            $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
                ->where(['booking_schedules.nric' => $data_person->nric,'booking_schedules.card_id'=>$data_person->card])->first();
            $t_grade = t_grade::get();

            return view('view_courses')->with(['t_grade' => $t_grade,'courses' => $course, "request" => $request]);
        }else if (!empty($jsonarr->msg) && $jsonarr->msg->netsTxnStatus == paid) {
            $data_person = json_decode($jsonarr->msg->b2sTxnEndURLParam);
            $BookingScheduleAppointment = booking_schedule::where(['nric' => $data_person->nric, 'card_id' => $data_person->card])
                ->update([
                    'paymentby' => "Enets",
                    'status_payment' => unpaid,
                    'netstxnref' => $jsonarr->msg->netsTxnRef,
                    'stagerespcode' => $jsonarr->msg->stageRespCode,
                ]);
            return redirect()->route('home');
        }else if (!empty($jsonarr->msg) && $jsonarr->msg->netsTxnStatus == C4) {
            $data_person = json_decode($jsonarr->msg->b2sTxnEndURLParam);
            $BookingScheduleAppointment = booking_schedule::where(['nric' => $data_person->nric, 'card_id' => $data_person->card])
                ->update([
                    'paymentby' => "Enets",
                    'status_payment' => unpaid,
                    'netstxnref' => $jsonarr->msg->netsTxnRef,
                    'stagerespcode' => $jsonarr->msg->stageRespCode,
                ]); 
            return redirect()->route('home');
        }else{
            $data_person = json_decode($jsonarr->b2sTxnEndURLParam);
            $BookingScheduleAppointment = booking_schedule::where(['nric' => $data_person->nric, 'card_id' => $data_person->card])
                ->update([
                    'paymentby' => "Enets",
                    'status_payment' => unpaid,
                    'netstxnref' => $jsonarr->netsTxnRef,
                    'stagerespcode' => $jsonarr->stageRespCode,
                ]);
            return redirect()->route('home');
        }
    }

}
