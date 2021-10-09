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
        die(print_r($request->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function b2sTxnEndURL(Request $request,$id)
    {
        die(print_r($id));
        $BookingScheduleAppointment = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->session()->all()['card']])
            ->update([
                'gst_id' => $request->session()->all()['grade_id'],
                'trans_date' => date('d/m/Y H:i:s'),
//                'expired_date' => date('Y-m-d', strtotime('+1 years')),
                'paymentby' => "Enets",
                'status_payment' => paid,
                'grand_total' => $request->session()->all()['grand_total'],
//                'receiptNo' => $this->receiptNo(),
                'status_app' => submitted,
                'transaction_amount_id' => $request->session()->all()['transaction_amount'],
            ]);

        $request->merge(['app_type' => $request->session()->all()['app_type'], 'thank_payment' => true,'card' => $request->session()->all()['card'],'router_name' => Route::getCurrentRoute()->getActionName()]);
        $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$request->session()->all()['card']])->first();
        $t_grade = t_grade::get();

        return view('view_courses')->with(['t_grade' => $t_grade,'courses' => $course, "request" => $request]);

    }

}
