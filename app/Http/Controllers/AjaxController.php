<?php

namespace App\Http\Controllers;

use App\Exports\BookingScheduleExport;
use App\grade;
use App\gst;
use App\sertifikat;
use App\User;
use Illuminate\Http\Request;
use App\booking_schedule;
use App\schedule_limit;
use App\transaction_amount;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cek_data_from()
    {
        $new = true;
        $replacement = false;
        $renewal = false;
        $data = booking_schedule::where(['user_id'=>Auth::id()])->first();
        if (!empty($data)){
            $new = false;
            $Datareplacement = booking_schedule::where(['user_id'=>Auth::id(),'status_app'=>payment])->first();
            if (!empty($Datareplacement)){
                $replacement = true;
            }
            if (!empty($data->expired_date) && Carbon::today()->toDateString() >= Carbon::parse($data->expired_date)->toDateString()){
                $renewal = true;
            }
        }
        $data = array('new'=>$new,'replacement'=>$replacement,'renewal'=>$renewal);

        return $data;
    }

    public function data_limit_shedule()
    {
        $limit_schedule = schedule_limit::where(['status'=>aktif])->get();
        return Datatables::of($limit_schedule)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>';

            return $btn;

        })->make(true);

    }
    public function update_limit_schedule(Request $request)
    {
        $update_schedule_limit  = schedule_limit::find($request->update_id);

        $update_schedule_limit  ->amount = $request->amount_update;

        $update_schedule_limit  ->save();

        return $update_schedule_limit;
    }
    public function insert_limit_schedule(Request $request)
    {
        $cek_booking_schedule = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',Carbon::today()->toDateString())
            ->count();
        if ($cek_booking_schedule == 0) {
            $Update_schedule_limit = DB::table('schedule_limits')
                ->update(['status' => not_aktif]);
            foreach ($request->start_at as $index_start =>$start) {
                if ($start == "Please choose") {
                    $data = start_empty;
                } else {
                    foreach ($request->end_at as $index_end => $end) {
                        if ($end == "Please choose") {
                            $data = end_empty;
                        } else {
                            foreach ($request->amount as $index_amount => $amount) {
//                                $data = array('start_at' => $start, 'end_at' => $end, 'amount' => $amount,'status' => aktif);
                                    if ($index_start == $index_end && $index_start == $index_amount && $index_end == $index_amount){

                                        $data = new schedule_limit();

                                        $data->date_schedule_limit = Carbon::today()->toDateString();

                                        $data->start_at = $start;

                                        $data->end_at = $end;

                                        $data->amount = $amount;

                                        $data->status = aktif;

                                        $data->save();
                                    }

                            }
                        }
                    }
                }

            }
        }else{
            $data = data_has_been_used_in_the_booking_schedule;
        }
        return $data;
    }
    public function history_login()
    {
        $history_login = User::whereNull('role')->get();

        return Datatables::of($history_login)->make(true);
    }
    public function security_employees()
    {
        $security_employees = sertifikat::select('sertifikats.id','users.nric','users.name','users.email','sertifikats.app_type','sertifikats.card_id','sertifikats.grade_id','grades.name as name_grade','sertifikats.expired_date')
                             ->leftjoin('users', 'sertifikats.user_id', '=', 'users.id')->leftjoin('grades', 'sertifikats.grade_id', '=', 'grades.id')->get();
        return Datatables::of($security_employees)->make(true);
    }
    public function data_price()
    {
        $transaction_amount = transaction_amount::select('transaction_amounts.id as transaction_amounts_id',"transaction_amounts.*","grades.*")->leftjoin('grades', 'transaction_amounts.grade_id', '=', 'grades.id')->get();
        return Datatables::of($transaction_amount)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>';

            return $btn;

        })->make(true);

    }
    public function data_gst()
    {
        $gst = gst::get();

        return Datatables::of($gst)->make(true);

    }

    public function create_gst(Request $request)
    {
        $create_gst = new gst();

        $create_gst->amount_gst = $request->amount_gst;

        $create_gst->create_date = Carbon::today()->toDateString();

        $create_gst->save();

        return $create_gst;

    }
    public function insert_price(Request $request)
    {
        $grade_id = null;
        $transaction_amount = data_already_exists;
        if ($request->grade_id != "Please choose"){
            $grade_id =$request->grade_id;
        }

//        if (empty($grade_id)){
//            $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id])->first();
//        }else{
//            $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id,'grade_id'=>$grade_id])->first();
//        }

        if (empty($val_transaction_amount)) {
            if (!empty($grade_id)) {
                if ($grade_id == so){
                    $grade_id = "SO";
                }elseif ($grade_id == sso){
                    $grade_id = "SSO";
                }else{
                    $grade_id = "SSS";
                }

                $grades = grade::where(['type'=>$grade_id])->get();
                foreach ($grades as $index => $f){
                   $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id,'grade_id'=>$f->id])->first();
                    if (empty($val_transaction_amount)){
                        $transaction_amount = new transaction_amount;

                        $transaction_amount->app_type = $request->app_type;

                        $transaction_amount->card_type = $request->card_id;

                        $transaction_amount->grade_id = $f->id;

                        $transaction_amount->transaction_amount = $request->transaction_amount;

                        $transaction_amount->save();
                    }
                }
            }else {
                $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id])->first();
                if (empty($val_transaction_amount)) {
                    $transaction_amount = new transaction_amount;

                    $transaction_amount->app_type = $request->app_type;

                    $transaction_amount->card_type = $request->card_id;

                    $transaction_amount->grade_id = $grade_id;

                    $transaction_amount->transaction_amount = $request->transaction_amount;

                    $transaction_amount->save();
                }
            }
//            $transaction_amount = new transaction_amount;
//
//            $transaction_amount->app_type = $request->app_type;
//
//            $transaction_amount->card_type = $request->card_id;
//
//            $transaction_amount->grade_id = $grade_id;
//
//            $transaction_amount->transaction_amount = $request->transaction_amount;
//
//            $transaction_amount->save();
        }
        return $transaction_amount;

    }

    public function update_price(Request $request)
    {
        $transaction_amount = transaction_amount::find($request->transaction_amounts_id);

        $transaction_amount->transaction_amount = $request->transaction_amount;

        $transaction_amount->save();

        return $transaction_amount;

    }
    public function cek_data_schedule(Request $request)
    {
        $data = '';
        $cek_booking_schedule = booking_schedule::whereDate('appointment_date','=',Carbon::parse($request->eventDate)->toDateString())
            ->distinct()->get(['time_start_appointment','time_end_appointment'])->toArray();
        foreach ($cek_booking_schedule as $index1 => $f){
            $booking_schedule = booking_schedule::whereDate('appointment_date','=',Carbon::parse($request->eventDate)->toDateString())->get();
            $data .= '<tr>';
            $data .= '<td>'.$f['time_start_appointment'].'-'.$f['time_end_appointment'].'</td>';
            $data .= '<td>';
            foreach ($booking_schedule as $index2 => $g) {
                if ($f['time_start_appointment'] == $g->time_start_appointment ){
                    $user = User::where(['id'=>$g->user_id])->first();
                    $data .= '<pre>'.$user->name.'</pre>';
                }
            }
            $data .= '</td>';

            $data .= '<td>';
            foreach ($booking_schedule as $index3 => $g) {
                if ($f['time_start_appointment'] == $g->time_start_appointment ){
                    if ($g->status_payment == paid){
                        $data .= '<pre>Paid</pre>';
                    }else{
                        $data .= '<pre>UnPaid</pre>';
                    }
                }
            }
            $data .= '</td>';
            $data .= '</tr>';
        }
            return $data;
    }
    public function schedule(){

        return Excel::download(new BookingScheduleExport, 'appointment.xlsx');
        
    }

    public function updatePassword(Request $request)
    {
        $cek_pass = User::where(['id'=>Auth::id()])->first();
        if(Hash::check($request->pass_old, Auth::user()->password))
        {
            $user  = User::find($cek_pass->id);

            $user  ->password = Hash::make($request->pass_new);

            $user  ->save();
        }else{
            $user = not_find_pass;
        }

        return $user;
    }
    public function cek_limit_schedule(Request $request)
    {
        return $this->view_time_schedule($this->time_schedule(Carbon::parse($request->eventDate)->toDateString()),$this->limit_schedule());
    }
    protected  function view_time_schedule($time_schedule,$limit_schedule){
        $data ='';
        foreach ($limit_schedule as $ls) {
            if ($time_schedule->count() > 0) {
                foreach ($time_schedule as $ts) {
                    $data .= ' <tr>';
                    $time = $ls->start_at . '-' . $ls->end_at;
                    if ($ls->start_at == $ts->time_start_appointment) {
                        if ($ls->amount == $ts->count()) {
                            $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                        }else{
                            $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'">&ensp;&ensp;&ensp;' . $time . '</td>';
                        }
                        $data .= '<td>' . $ts->count() . '</td>';
                        $data .= '<td>' . $ls->amount . '</td>';
                    }else{
                        $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'">&ensp;&ensp;&ensp;' . $time . '</td>';
                        $data .= '<td>0</td>';
                        $data .= '<td>' . $ls->amount . '</td>>';
                    }
                    $data .= '</tr>';
                }
            }else{
                $time = $ls->start_at . '-' . $ls->end_at;
                $data .= ' <tr>';
                $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'">&ensp;&ensp;&ensp;' . $time . '</td>';
                $data .= '<td>0</td>';
                $data .= '<td>' . $ls->amount . '</td>>';
                $data .= '</tr>';

            }
        }
        return $data;
    }
    protected function limit_schedule()
    {
        $schedule_limit = schedule_limit::where(["status"=>aktif])->get();
        return $schedule_limit;
    }

    protected function time_schedule($eventDate){
        $data = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->get();
        return $data;
    }


}
