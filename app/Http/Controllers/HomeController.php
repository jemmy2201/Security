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

            $booking_schedule = new booking_schedule;

            $booking_schedule->app_type = $request->app_type;

            $booking_schedule->card_id = $request->card;

            $booking_schedule->grade_id = $grade;

            $booking_schedule->declaration_date = Carbon::today()->toDateString();

            $booking_schedule->status_app = submission;

            $booking_schedule->user_id = Auth::id();

            $booking_schedule->save();
        }else{
            $booking_schedule = $booking_schedule::where(['user_id'=>Auth::id()])
                                ->update([
                                    'app_type' => $request->app_type,
                                    'card_id' => $request->card,
                                    'grade_id' => $grade,
                                    'declaration_date' => Carbon::today()->toDateString(),
                                    'status_app' => submission,
                                    'user_id' => Auth::id(),
                                ]);
        }
        return view('book_appointment')->with(["request"=>$request]);
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
