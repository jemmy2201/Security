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
use DB;
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
        $cek_del_schedule = booking_schedule::where(['user_id'=>Auth::id()])->whereIn('Status_app', [ draft])->get();

        // Delete data if not payment 3 month
        foreach ($cek_del_schedule as $f){
            $cek_Month = $this->cek_month($f->appointment_date);
            if ($cek_Month == three_month){
                $del_schedule = booking_schedule::find($f->id);
                $del_schedule->delete();
            }
        }
        // End Delete data if not payment 3 month
        $schedule = booking_schedule::where(['user_id'=>Auth::id()])->whereNotIn('Status_app', [completed])->get();

        $sertifikat = sertifikat::where(['user_id'=>Auth::id()])->orderBy('id','desc')->get();

        $replacement = booking_schedule::where(['user_id'=>Auth::id()])->get();

        $renewal = booking_schedule::where(['user_id'=>Auth::id()])->get();

        $grade = grade::get();
        if (Auth::user()->role == admin){
            return view('admin/historylogin');
        }
        return view('home')->with(["schedule"=>$schedule,"sertifikat"=>$sertifikat,"grade"=>$grade,"replacement"=>$replacement,"renewal"=>$renewal]);
    }
    public function personaldata(Request $request)
    {
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('personal_particular')->with(['personal'=>$personal,"request"=>$request]);
    }
    public function resubmission(Request $request,$app_type,$card)
    {
        $request->merge(['app_type' => $app_type,'card' => $card]);
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('personal_particular')->with(['personal'=>$personal,"request"=>$request]);
    }
    public function replacement_personaldata(Request $request,$card)
    {
        $request->merge(['app_type' => replacement,'card' => $card]);
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('personal_particular')->with(['personal'=>$personal,"request"=>$request]);
    }

    public function renewal_personaldata(Request $request,$card)
    {
        $request->merge(['app_type' => renewal,'card' => $card]);
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('personal_particular')->with(['personal'=>$personal,"request"=>$request]);
    }

    public function submission(Request $request)
    {

        $grade = null;
        $replacement = null;
        $view_declare = null;
        $cek_grade = null;
        $data_resubmission = null;
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

        $resubmission = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card,'Status_app'=>resubmission])->first();
        if ($request->card == so_app){
            if ($request->app_type== renewal){
                if (!empty($resubmission)){
                    $data_resubmission = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])->first();
                    $grade = grade::get();
                    $cek_grade = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                }else {
                    $renewal = booking_schedule::where(['user_id' => Auth::id()])->leftjoin('grades', 'booking_schedules.grade_id', '=', 'grades.id')->first();
                    $grade = grade::where(['card_id' => $renewal->card_id])->get();
                    $cek_grade = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                }
            }elseif ($request->app_type== replacement){
                if (!empty($resubmission)){
                    $data_resubmission = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])->first();
                    $grade = grade::get();
                    $cek_grade = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                }else {
//                  $replacement = booking_schedule::first();
                    $replacement = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                    $grade = grade::where(['card_id' => $replacement->card_id])->get();
                    $cek_grade = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                }
            }else{
                if (!empty($request->Cgrade)){
                    // view declare more than 1
                    $grade = grade::get();
                    // end view declare more than 1
                }else{
                    if (!empty($resubmission)){
                        $data_resubmission = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])->first();
                        $grade = grade::get();
                        $cek_grade = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                    }else {
                        // user cannot belong to declare
                        $grade = grade::get();
                        $cek_grade = booking_schedule::where(['user_id' => Auth::id(), 'card_id' => $request->card])->first();
                        // End user cannot belong to declare
                    }
                }
            }
        }else{
           if ($request->app_type== replacement || $request->app_type== renewal){
               $replacement = booking_schedule::where(['user_id'=>Auth::id()])->first();
//                $request->merge(['card' => $replacement->card_id]);
           }
        }
        $personal = User::where(['id'=>Auth::id()])->first();
        return view('submission')->with(['data_resubmission'=>$data_resubmission,'resubmission'=>$resubmission,'cek_grade'=>$cek_grade,'personal'=>$personal,"grade"=>$grade,"request"=>$request,"replacement"=>$replacement,"view_declare"=>$view_declare]);
    }
    public function declare_submission(Request $request)
    {
        $take_grade = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>so_app])->first();
        $selected_grade = booking_schedule::where(['card_id'=>so_app,'user_id'=>Auth::id()])->first();
        $grade = grade::where(['card_id'=>so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
        if (!empty($take_grade)) {
            foreach ($grade as $index => $f) {
                foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
                    if ($f->id == $g) {
                        $grade[$index]->take_grade = true;
                    }
                }
            }
        }

//        jika milih declare berurutan dan sesuai grade
//        $grade = grade::where(['card_id'=>so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
//        if (!empty($take_grade)){
//            foreach ($grade as $index => $f) {
//                foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
//                    if ($f->id == $g) {
//                        $grade[$index]->take_grade = true;
//                    }
//                }
//
//                if ($take_grade['grade_id'] == $f->type){
//                    $grade[$index]->display = false;
//                }else{
//                    $grade[$index]->display = true;
//                }
//                if ($take_grade['grade_id'] == $f->type){
//                    $grade[$index]->display = false;
//                }else{
//                    $grade[$index]->display = true;
//                }
//            }
//        }else {
//            foreach ($grade as $index => $f) {
//                if ($f->type == sso || $f->type == sss){
//                    $grade[$index]->display = true;
//                }
//            }
//        }
//        End jika milih declare berurutan dan sesuai grade

        return view('declare_submission')->with(["grade"=>$grade,"request"=>$request]);

    }
    public function book_appointment(Request $request)
    {
        $grade = false;
        if (!empty($request->grade)){
            $grade = $request->grade;
        }
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])->first();
        if (!empty($booking_schedule) && $booking_schedule->Status_app == resubmission){
            $this->Saveresubmission($request,$grade);
            return redirect('/home');
        }elseif (empty($booking_schedule)){
            $this->NewBookingSchedule($request,$grade);
        }else{
            $this->UpdateBookingSchedule($request,$grade);
        }
        return view('book_appointment')->with(["request"=>$request]);
    }
    public function HistoryBookAppointment(Request $request,$app_type,$card)
    {
        $request->merge(['app_type' => $app_type,'card' => $card]);

        return view('book_appointment')->with(["request"=>$request]);
    }

    public function View_payment(Request $request)
    {
        $this->UpdateBookingScheduleAppointment($request);
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])->first();
        if (!empty($booking_schedule->grade_id)){
                  $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_type'=>$booking_schedule->grade_id])->first();
//                foreach (json_decode($booking_schedule->grade_id) as $f){
//                    $transaction_amount= transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$f])->first();
//                    $Array_transaction_amount[] = $transaction_amount->transaction_amount;
//                }
//                    $addition_transaction_amount = array_sum($Array_transaction_amount);
        }else{
            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id])->first();
        }
        $gst = gst::first();

        return view('payment_detail')->with(["gst"=>$gst,"booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount,'request'=>$request]);
    }

    public function HistoryViewPayment(Request $request,$app_type,$card)
    {
        $request->merge(['app_type' => $app_type,'card' => $card]);

//        $this->UpdateBookingScheduleAppointment($request);
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$card])->first();
        $addition_transaction_amount='';
        if (!empty($booking_schedule->grade_id)){
            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_type'=>$booking_schedule->grade_id])->first();
//            foreach (json_decode($booking_schedule->grade_id) as $f){
//                $transaction_amount= transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$f])->first();
//                $Array_transaction_amount[] = $transaction_amount->transaction_amount;
//            }
//                $addition_transaction_amount = array_sum($Array_transaction_amount);
        }else{
            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id])->first();
        }
        $gst = gst::first();
        return view('payment_detail')->with(["gst"=>$gst,"booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount,'addition_transaction_amount'=>$addition_transaction_amount,'request'=>$request]);
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
        $BookingScheduleAppointment = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request['card']])
            ->update([
                'gst_id' => $request['grade_id'],
                'trans_date' => Carbon::today()->toDateString(),
//                'expired_date' => date('Y-m-d', strtotime('+1 years')),
                'paymentby' => $payment_method,
                'status_payment' => paid,
                'grand_total' => $request['grand_total'],
                'receiptNo' => $this->receiptNo(),
                'status_app' => submitted,
                'transaction_amount_id' => $request['transaction_amount_id'],
            ]);

//        $this->create_setifikat($request);
        return $BookingScheduleAppointment;
    }
    protected function cek_month($date){
        $date1 = Carbon::parse($date)->toDateString();
        $date2 = Carbon::today()->toDateString();

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        return $diff;
    }
    protected function receiptNo(){
        $booking_schedule = sertifikat::whereDate('trans_date', '=', Carbon::today()->toDateTimeString())->get();

        if ($booking_schedule->count() > 0){
            $booking_schedule =$booking_schedule->count()+1;
            $data_substr = strlen((string)$booking_schedule);
            $nnnn = substr(nnnn, $data_substr);
            $booking_schedule = $nnnn.''.$booking_schedule;
        }else{
            $booking_schedule = "0001";
        }
        $data = Carbon::today()->format('Ymd').''.$booking_schedule;
//        $data = "".Carbon::today()->format('d')."/".Carbon::today()->format('m')."/".Carbon::today()->format('y')."/".$booking_schedule;
        return $data;
    }
    protected function create_setifikat($request)
    {
        $data = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request['card']])->first();

        $gst = gst::where(['id'=>$data->gst_id])->first();

        $transaction_amount = transaction_amount::where(['id'=>$data->transaction_amount_id])->first();

        $sertifikat = new sertifikat();

        $sertifikat->app_type           = $data->app_type;

        $sertifikat->card_id            = $data->card_id;

        $sertifikat->grade_id           = $data->grade_id;

        $sertifikat->array_grade        = $data->array_grade;

        $sertifikat->bsoc               = $data->bsoc;

        $sertifikat->ssoc               = $data->ssoc;

        $sertifikat->sssc               = $data->sssc;

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

        $sertifikat->receiptNo          = $data->receiptNo;

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
        $BookingScheduleAppointment = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])
                                        ->update([
                                            'appointment_date' => $date,
                                            'time_start_appointment' => $data->start_at,
                                            'time_end_appointment' => $data->end_at,
                                            'status_app' => draft,
                                        ]);
        return $BookingScheduleAppointment;
    }
    protected function UpdateBookingSchedule($request,$grade)
    {
//        $request->validate([
//            'upload_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

//        if (!empty($grade)){
//            $grade = json_encode($grade);
//        }else{
//            $grade = $grade;
//        }
        $bsoc = null;
        $ssoc = null;
        $sssc = null;
        $merge_grade = null;

        $this->Upload_Image($request);
        $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])->first();
        if ($booking_schedule->grade_id == so){
            $array_dataDB = json_decode($booking_schedule->array_grade);
            $new_array_data = json_decode($request->Cgrade[0]);
            $array_grades = array_merge($array_dataDB,$new_array_data);
            $bsoc = $this->take_grade(json_encode($array_grades));
        }elseif ($booking_schedule->grade_id == sso){
            $array_dataDB = json_decode($booking_schedule->array_grade);
            $new_array_data = json_decode($request->Cgrade[0]);
            $array_grades = array_merge($array_dataDB,$new_array_data);
            $ssoc = $this->take_grade(json_encode($array_grades));
        }elseif ($booking_schedule->grade_id == ss){
            $array_dataDB = json_decode($booking_schedule->array_grade);
            $new_array_data = json_decode($request->Cgrade[0]);
            $array_grades = array_merge($array_dataDB,$new_array_data);
            $sssc = $this->take_grade(json_encode($array_grades));
        }elseif ($booking_schedule->grade_id == sss){
            $array_dataDB = json_decode($booking_schedule->array_grade);
            $new_array_data = json_decode($request->Cgrade[0]);
            $array_grades = array_merge($array_dataDB,$new_array_data);
            $sssc = $this->take_grade(json_encode($array_grades));
        }elseif ($booking_schedule->grade_id == cso){
            $array_dataDB = json_decode($booking_schedule->array_grade);
            $new_array_data = json_decode($request->Cgrade[0]);
            $array_grades = array_merge($array_dataDB,$new_array_data);
            $sssc = $this->take_grade(json_encode($array_grades));
        }
        if ($booking_schedule->grade_id) {
            $take_grade = json_decode($booking_schedule->array_grade);
            $new_take_grade = json_decode($request->Cgrade[0]);
            // untuk mengatasi jika di refresh chorem maka data array tidak double
            foreach ($new_take_grade as $index => $f){
                if (!in_array($f,$take_grade)) {
                    array_push($take_grade, $f);
                    $merge_grade = $take_grade;
                }else{
                    $merge_grade = $take_grade;
                }
            }
            // End untuk mengatasi jika di refresh chorem maka data array tidak double
        }

        if ($request->app_type == renewal){
            $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
//                    'card_id' => $request->card,
//                    'grade_id' => $grade,
                    'bsoc' => $bsoc,
                    'ssoc' => $ssoc,
                    'sssc' => $sssc,
                    'array_grade' => $merge_grade,
                    'declaration_date' => Carbon::today()->toDateString(),
//                    'status_app' => submission,
                    'trans_date' => null,
                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
//                    'gst_id' => null,
//                    'transaction_amount_id' => null,
//                    'grand_total' => null,
                    'paymentby' => null,
                    'receiptNo' => null,
                    'status_payment' => null,
                    'user_id' => Auth::id(),
                ]);
        }elseif ($request->app_type == replacement){
            $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
//                    'card_id' => $request->card,
//                    'grade_id' => $grade,
                    'declaration_date' => Carbon::today()->toDateString(),
//                    'status_app' => submission,
                    'array_grade' => $merge_grade,
                    'trans_date' => null,
                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
//                    'gst_id' => null,
//                    'transaction_amount_id' => null,
//                    'grand_total' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'receiptNo' => null,
                    'user_id' => Auth::id(),
                ]);
        }else{
            $booking_schedule = booking_schedule::where(['user_id'=>Auth::id(),'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
                    'card_id' => $request->card,
//                    'grade_id' => $grade,
                    'array_grade' => $request->Cgrade[0],
                    'declaration_date' => Carbon::today()->toDateString(),
//                    'status_app' => submission,
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
                    'receiptNo' => null,
                    'user_id' => Auth::id(),
                ]);
        }

        return $booking_schedule;
    }

    protected  function take_grade($array_grades)
    {
        // BSOC, SSOC, SSSC
        $Cgrade = json_decode($array_grades);
        $get_grade = grade::whereNull('delete_soft')->get();
        foreach ($get_grade as $index => $f) {
            foreach ($Cgrade as $index => $g) {
                if ($f->id == $g){
                    $get_grade[$index]->Cgrade = true ;
                }
            }
        }

        foreach ($get_grade as $index => $f) {
            if($f->Cgrade == true){
                $get_grade[$index] =1;
            }else{
                $get_grade[$index] =0;
            }
        }
        $result = str_replace( array(",", "[", "]"), '', json_encode($get_grade));;

        return $result;
        // End BSOC, SSOC, SSSC
    }
    protected function Upload_Image($request)
    {
        $imageName = Auth::user()->passid.''.substr(Auth::user()->nric, -4).'.'.$request->upload_profile->getClientOriginalExtension();

        $request->upload_profile->move(public_path('img/img_users'), $imageName);

        $UpdateUser = User::find(Auth::id());

        $UpdateUser->photo = $imageName;

        $UpdateUser->save();

        return $UpdateUser;
    }
    protected function Saveresubmission($request,$grade)
    {
        return $this->Upload_Image($request);
    }
    protected function NewBookingSchedule($request,$grade)
    {
        $request->validate([
            'upload_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $bsoc = null;
        $ssoc = null;
        $sssc = null;

        if ($request->card == so_app){
            $grade = so;
            // BSOC, SSOC, SSSC
            $bsoc = $this->take_grade($request->Cgrade[0]);
            // End BSOC, SSOC, SSSC
        }else{
            $grade = null;
        }

        $this->Upload_Image($request);

        $booking_schedule = new booking_schedule;

        $booking_schedule->app_type = $request->app_type;

        $booking_schedule->card_id = $request->card;

        $booking_schedule->grade_id = $grade;

        $booking_schedule->array_grade = $request->Cgrade[0];

        $booking_schedule->bsoc = $bsoc;

        $booking_schedule->ssoc = $ssoc;

        $booking_schedule->sssc = $sssc;

        $booking_schedule->declaration_date = Carbon::today()->toDateString();

//        $booking_schedule->status_app = submission;

        $booking_schedule->user_id = Auth::id();

        $booking_schedule->save();

        return $booking_schedule;
    }

    protected function UpdateUsers($request){
    if(!empty($request['homeno']) && !empty($request['mobileno'])){
        $UpdateUser = User::find(Auth::id());

        $UpdateUser->email = $request['email'];

        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->save();
    }elseif(!empty($request['homeno'])) {
         $UpdateUser = User::find(Auth::id());

         $UpdateUser->homeno = $request['homeno'];

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
            "homeno"=>$request->homeno,
            "mobileno"=>$request->mobileno
        );

        $personal = User::where(['id'=>Auth::id()])->first();

        $result=array_diff($originData,$personal->toArray());

        return $result;
    }
}
