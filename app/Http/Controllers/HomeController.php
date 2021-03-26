<?php

namespace App\Http\Controllers;

use App\grade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\booking_schedule;
use App\User;
use App\detail_application;
use App\payment;
use App\transaction_amount;
use App\gst;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $schedule = booking_schedule::where(['user_Id'=>Auth::id()])->get();

        return view('home')->with(["schedule"=>$schedule]);
    }
    public function personaldata(Request $request)
    {
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('personal_particular')->with(['personal'=>$personal,"request"=>$request]);
    }

    public function submission(Request $request)
    {
        $grade = null;

        $diff_data = $this->diff_data($request);

        if ($diff_data){
            // Update
            $this->UpdateUsers($diff_data);
        }
        if ($request->card== so_app){
            $grade = grade::where(['card_id'=>$request->card])->get();
        }
        $personal = User::where(['id'=>Auth::id()])->first();

        return view('submission')->with(['personal'=>$personal,"grade"=>$grade,"request"=>$request]);
    }

    public function book_appointment(Request $request)
    {
        $grade = false;
        if (!empty($request->grade)){
            $grade = $request->grade;
        }
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])->first();
        if (empty($booking_schedule)){
            $this->NewBookingSchedule($request,$grade);
        }else{
            $this->UpdateBookingSchedule($request,$grade);
        }
        return view('book_appointment')->with(["request"=>$request]);
    }

    public function View_payment(Request $request)
    {
        $this->UpdateBookingScheduleAppointment($request);

        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])->first();
        $transaction_amount = transaction_amount::get();
        $gst = gst::first();
        return view('payment_detail')->with(["booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount]);
    }

    public function Createpayment(Request $request)
    {
        $payment_method = $this->payment_method($request);

        if ($payment_method){
            $this->NewPayment($request);
        }

        $schedule = booking_schedule::where(['user_Id'=>Auth::id()])->first();
        return redirect()->route('home');
    }

    protected  function NewPayment($request){
        if ($request->payment_method == paynow){
            $payment_method = 'paynow';
        }elseif ($request->payment_method == enets){
            $payment_method = 'enets';
        }elseif ($request->payment_method == visa){
            $payment_method = 'visa';
        }elseif ($request->payment_method == mastercard){
            $payment_method = 'mastercard';
        }
        $BookingScheduleAppointment = booking_schedule::where(['user_id'=>Auth::id()])
            ->update([
                'gst_id' => $request->gst,
                'trans_date' => Carbon::today()->toDateString(),
                'expired_date' => date('Y-m-d', strtotime('+1 years')),
                'paymentby' => $payment_method,
                'status_payment' => true,
                'grand_total' => $request->grand_total,
                'status_app' => payment,
            ]);
        return $BookingScheduleAppointment;
    }

    protected function payment_method($request){
        if ($request->payment_method == paynow){

        }elseif ($request->payment_method == enets){

        }elseif ($request->payment_method == visa){

        }elseif ($request->payment_method == mastercard){

        }
        return true;
    }
    protected function UpdateBookingScheduleAppointment($request)
    {
        $date = Carbon::parse($request->view_date)->toDateString().' '.$request->time_schedule.':00';
        $BookingScheduleAppointment = booking_schedule::where(['user_id'=>Auth::id()])
                                        ->update([
                                            'appointment_date' => $date,
                                            'status_app' => book_appointment,
                                        ]);
        return $BookingScheduleAppointment;
    }
    protected function UpdateBookingSchedule($request,$grade)
    {
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])
            ->update([
                'app_type' => $request->app_type,
                'card_id' => $request->card,
                'grade_id' => $grade,
                'declaration_date' => Carbon::today()->toDateString(),
                'status_app' => submission,
                'user_id' => Auth::id(),
            ]);
        return $booking_schedule;
    }
    protected function NewBookingSchedule($request,$grade)
    {
        $booking_schedule = new booking_schedule;

        $booking_schedule->app_type = $request->app_type;

        $booking_schedule->card_id = $request->card;

        $booking_schedule->grade_id = $grade;

        $booking_schedule->declaration_date = Carbon::today()->toDateString();

        $booking_schedule->status_app = submission;

        $booking_schedule->user_id = Auth::id();

        $booking_schedule->save();

        return $booking_schedule;
    }

    protected function UpdateUsers($request){
        $UpdateUser = User::find(Auth::id());

        $UpdateUser->email = $request['email'];

        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->save();

        return $UpdateUser;
    }
    protected function diff_data($request)
    {
        $originData=array(
            "email"=>$request->email,
            "mobileno"=>$request->mobileno
        );

        $personal = User::where(['id'=>Auth::id()])->first();

        $result=array_diff($originData,$personal->toArray());

        return $result;
    }
}
