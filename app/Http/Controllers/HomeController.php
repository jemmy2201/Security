<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\booking_schedule;
use App\User;
use App\detail_application;
use App\payment;
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
    public function personaldata($value_application,$value_request)
    {
        $personal = User::where(['user_Id'=>Auth::id()])->first();
        return view('personaldata')->with(['personal'=>$personal,"request"=>$request]);
    }

    public function courses(Request $request)
    {
        $detail_app = null;

        $diff_data = $this->diff_data($request);

        if ($diff_data){
            // Update
            $this->UpdateUsers($diff_data);
        }

        if ($request->application_type== application_so){
            $detail_app = detail_application::where(['application_id'=>$request->application_id]);
        }

        $personal = User::where(['user_Id'=>Auth::id()])->first();

        return view('courses')->with(['personal'=>$personal,"detail_app"=>$detail_app]);
    }

    public function choosedate(Request $request)
    {
        return view('choosedate')->with(["request"=>$request]);
    }

    public function View_payment(Request $request)
    {
        $this->NewBookingSchedule($request);

        $schedule = booking_schedule::where(['user_Id'=>Auth::id()])->get();

        return view('payment')->with(["schedule"=>$schedule,"request"=>$request]);
    }

    public function Createpayment(Request $request)
    {
        $this->NewBookingSchedule($request);

        $schedule = booking_schedule::where(['user_Id'=>Auth::id()])->get();

        return view('payment')->with(["schedule"=>$schedule,"request"=>$request]);
    }

    protected function NewPayment($request)
    {
        $InPayment = new payment();

        $InPayment->booking_id = $request->booking_id;

        $InPayment->cardz = $request->cardz;

        $InPayment->status = $request->status;

        $InPayment->user_id = Auth::id();

        $InPayment->save();
    }
    protected function NewBookingSchedule($request)
    {
        $InSchedule = new booking_schedule;

        $InSchedule->start_at = $request->start_at;

        $InSchedule->end_at = $request->end_at;

        $InSchedule->application_type = $request->application_type;

        $InSchedule->application_id = $request->application_id;

        $InSchedule->detail_application = $request->detail_application;

        $InSchedule->user_id = Auth::id();

        $InSchedule->save();
    }

    protected function UpdateUsers($request){

        $UpdateUser = User::find(Auth::id());

        $UpdateUser->email = $request->email;

        $UpdateUser->mobileno = $request->mobileno;

        $UpdateUser->save();

        return $UpdateUser;
    }
    protected function diff_data($request)
    {
        $originData=array(
            "email"=>$request->email,
            "mobileno"=>$request->mobileno
        );

        $personal = User::where(['user_Id'=>Auth::id()])->get();

        $result=array_diff($originData,$personal->toArray());

        return $result;
    }
}
