<?php

namespace App\Http\Controllers;

use App\grade;
use App\schedule_limit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\booking_schedule;
use App\User;
use App\detail_application;
use App\payment;
use App\transaction_amount;
use App\gst;
use App\sertifikat;
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
        $schedule = booking_schedule::where(['user_Id'=>Auth::id()])->whereIn('Status_app', [submission, book_appointment])->get();

        $sertifikat = sertifikat::where(['user_Id'=>Auth::id()])->get();

        $grade = grade::get();

        if (Auth::user()->role == admin){
            return view('admin/historylogin');
        }
        return view('home')->with(["schedule"=>$schedule,"sertifikat"=>$sertifikat,"grade"=>$grade]);
    }
    public function personaldata(Request $request)
    {
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('personal_particular')->with(['personal'=>$personal,"request"=>$request]);
    }

    public function submission(Request $request)
    {
        $grade = null;
        $replacement = null;
        $view_declare = null;
        $diff_data = $this->diff_data($request);

        if ($diff_data){
            // Update
            $this->UpdateUsers($diff_data);
        }
        // view_declare
        if (!empty($request->Cgrade)){
            $view_declare = $request->Cgrade;
        }
        // End view_declare
        if ($request->app_type== renewal || $request->app_type== replacement) {
            $data = booking_schedule::where(['user_id'=>Auth::id()])->first();
            $request->merge(['card' => $data->card_id]);
        }
        if ($request->card == so_app){
            if ($request->app_type== renewal){
                if (!empty($request->Cgrade)){
                    // view declare more than 1
                    $grade = null;
                    // end view declare more than 1
                }else{
                    $renewal = booking_schedule::where(['user_id'=>Auth::id()])->leftjoin('grades', 'booking_schedules.grade_id', '=', 'grades.id')->first();
                    $grade = grade::where(['card_id'=>$renewal->card_id])->get();
                }
            }elseif ($request->app_type== replacement){
//                $replacement = booking_schedule::where(['user_id'=>Auth::id()])->leftjoin('grades', 'booking_schedules.grade_id', '=', 'grades.id')->first();
                $replacement = booking_schedule::first();
            }else{
                if (!empty($request->Cgrade)){
                    // view declare more than 1
                    $grade = null;
                    // end view declare more than 1
                }else{
                    $grade = grade::where(['card_id'=>$request->card])->get();
                }
            }
        }else{
           if ($request->app_type== replacement || $request->app_type== renewal){
               $replacement = booking_schedule::where(['user_id'=>Auth::id()])->first();
                $request->merge(['card' => $replacement->card_id]);
           }
        }
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('submission')->with(['personal'=>$personal,"grade"=>$grade,"request"=>$request,"replacement"=>$replacement,"view_declare"=>$view_declare]);
    }
    public function declare_submission(Request $request)
    {
        $grade = grade::where(['card_id'=>$request->card])->get();

        return view('declare_submission')->with(["grade"=>$grade,"request"=>$request]);

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
    public function HistoryBookAppointment(Request $request)
    {

        return view('book_appointment')->with(["request"=>$request]);
    }

    public function View_payment(Request $request)
    {
        $this->UpdateBookingScheduleAppointment($request);
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])->first();
        if (!empty($booking_schedule->grade_id)){
            foreach (json_decode($booking_schedule->grade_id) as $f){
                $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$f])->first();
            }
//            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$booking_schedule->grade_id])->first();
        }else{
            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id])->first();
        }
        $gst = gst::first();
        return view('payment_detail')->with(["gst"=>$gst,"booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount]);
    }

    public function HistoryViewPayment(Request $request)
    {
//        $this->UpdateBookingScheduleAppointment($request);
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])->first();
        if (!empty($booking_schedule->grade_id)){
//            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$booking_schedule->grade_id])->first();
            foreach (json_decode($booking_schedule->grade_id) as $f){
                $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$f])->first();
            }
        }else{
            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id])->first();
        }
        $gst = gst::first();
        return view('payment_detail')->with(["gst"=>$gst,"booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount]);
    }

    public function Createpayment(Request $request)
    {
        $payment_method = $this->payment_method($request);

        if ($payment_method){
            $this->NewPayment($request->all());
        }

        $schedule = booking_schedule::where(['user_Id'=>Auth::id()])->first();
        return redirect()->route('home');
    }

    protected  function NewPayment($request){
        if ($request['payment_method'] == paynow){
            $payment_method = 'paynow';
        }elseif ($request['payment_method'] == enets){
            $payment_method = 'enets';
        }elseif ($request['payment_method'] == visa){
            $payment_method = 'visa';
        }elseif ($request['payment_method'] == mastercard){
            $payment_method = 'mastercard';
        }
        $BookingScheduleAppointment = booking_schedule::where(['user_id'=>Auth::id()])
            ->update([
                'gst_id' => $request['grade_id'],
                'trans_date' => Carbon::today()->toDateString(),
                'expired_date' => date('Y-m-d', strtotime('+1 years')),
                'paymentby' => $payment_method,
                'status_payment' => paid,
                'grand_total' => $request['grand_total'],
                'status_app' => payment,
                'transaction_amount_id' => $request['transaction_amount_id'],
            ]);

        $this->create_setifikat($request);
        return $BookingScheduleAppointment;
    }
    protected function create_setifikat($request)
    {
        $data = booking_schedule::where(['user_id'=>Auth::id()])->first();

        $gst = gst::where(['id'=>$data->gst_id])->first();

        $transaction_amount = transaction_amount::where(['id'=>$data->transaction_amount_id])->first();

        $sertifikat = new sertifikat();

        $sertifikat->app_type           = $data->app_type;

        $sertifikat->card_id            = $data->card_id;

        $sertifikat->grade_id           = $data->grade_id;

        $sertifikat->declaration_date   = $data->declaration_date;

        $sertifikat->gst                = $gst->amount_gst;

        $sertifikat->grand_gst          = $request['grand_gst'];

        $sertifikat->trans_date         = $data->trans_date;

        $sertifikat->expired_date       = $data->expired_date;

        $sertifikat->appointment_date   = $data->appointment_date;

        $sertifikat->time_start_appointment   = $data->time_start_appointment;

        $sertifikat->time_end_appointment   = $data->time_end_appointment;

        $sertifikat->transaction_amount   = $transaction_amount->transaction_amount;

        $sertifikat->paymentby          = $data->paymentby;

        $sertifikat->status_payment     = $data->status_payment;

        $sertifikat->grand_total        = $data->grand_total;

        $sertifikat->status_app         = $data->Status_app;

        $sertifikat->status_payment     = $data->status_payment;

        $sertifikat->user_id            = $data->user_id;

        $sertifikat->save();

        return $sertifikat;

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
        $date = Carbon::parse($request->view_date)->toDateString();
        $data = schedule_limit::where(['id'=>$request->limit_schedule_id])->first();
        $BookingScheduleAppointment = booking_schedule::where(['user_id'=>Auth::id()])
                                        ->update([
                                            'appointment_date' => $date,
                                            'time_start_appointment' => $data->start_at,
                                            'time_end_appointment' => $data->end_at,
                                            'status_app' => book_appointment,
                                        ]);
        return $BookingScheduleAppointment;
    }
    protected function UpdateBookingSchedule($request,$grade)
    {
        $request->validate([
            'upload_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!empty($grade)){
            $grade = json_encode($grade);
        }else{
            $grade = $grade;
        }

        $imageName = time().'.'.$request->upload_profile->extension();

        $request->upload_profile->move(public_path('img/img_users'), $imageName);

        $UpdateUser = User::find(Auth::id());

        $UpdateUser->photo = $imageName;

        $UpdateUser->save();
        if ($request->app_type == renewal){
            $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])
                ->update([
                    'app_type' => $request->app_type,
//                    'card_id' => $request->card,
                    'grade_id' => $grade,
                    'declaration_date' => Carbon::today()->toDateString(),
                    'status_app' => submission,
                    'trans_date' => null,
//                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
                    'gst_id' => null,
                    'transaction_amount_id' => null,
                    'grand_total' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'user_id' => Auth::id(),
                ]);
        }elseif ($request->app_type == replacement){
            $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])
                ->update([
                    'app_type' => $request->app_type,
//                    'card_id' => $request->card,
//                    'grade_id' => $grade,
                    'declaration_date' => Carbon::today()->toDateString(),
                    'status_app' => submission,
                    'trans_date' => null,
                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
                    'gst_id' => null,
                    'transaction_amount_id' => null,
                    'grand_total' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'user_id' => Auth::id(),
                ]);
        }else{
            $booking_schedule = booking_schedule::where(['user_id'=>Auth::id()])
                ->update([
                    'app_type' => $request->app_type,
                    'card_id' => $request->card,
                    'grade_id' => $grade,
                    'declaration_date' => Carbon::today()->toDateString(),
                    'status_app' => submission,
                    'trans_date' => null,
                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
                    'gst_id' => null,
                    'transaction_amount_id' => null,
                    'grand_total' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'user_id' => Auth::id(),
                ]);
        }

        return $booking_schedule;
    }
    protected function NewBookingSchedule($request,$grade)
    {
        $request->validate([
            'upload_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if (!empty($grade)){
            $grade = json_encode($grade);
        }else{
            $grade = $grade;
        }
        $imageName = time().'.'.$request->upload_profile->extension();

        $request->upload_profile->move(public_path('img/img_users'), $imageName);

        $UpdateUser = User::find(Auth::id());

        $UpdateUser->photo = $imageName;

        $UpdateUser->save();

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
    if(!empty($request['email']) && !empty($request['mobileno'])){
        $UpdateUser = User::find(Auth::id());

        $UpdateUser->email = $request['email'];

        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->save();
    }elseif(!empty($request['email'])) {
         $UpdateUser = User::find(Auth::id());

         $UpdateUser->email = $request['email'];

         $UpdateUser->save();
     }elseif (!empty($request['mobileno'])){
         $UpdateUser = User::find(Auth::id());

         $UpdateUser->mobileno = $request['mobileno'];

         $UpdateUser->save();
     }
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
