<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\booking_schedule;
use App\schedule_limit;
use App\transaction_amount;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
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
        $data = booking_schedule::where(['user_Id'=>Auth::id()])->first();

        if (!empty($data)){
            $replacement = true;
            $new = false;
            if (Carbon::today()->toDateString() >= Carbon::parse($data->expired_date)->toDateString()){
                $renewal = true;
            }
        }
        $data = array('new'=>$new,'replacement'=>$replacement,'renewal'=>$renewal);

        return $data;
    }

    public function data_price()
    {
        $transaction_amount = transaction_amount::select('transaction_amounts.id as transaction_amounts_id',"transaction_amounts.*","grades.*")->leftjoin('grades', 'transaction_amounts.grade_id', '=', 'grades.id')->get();
        return Datatables::of($transaction_amount)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>';

            return $btn;

        })->make(true);

    }

    public function insert_price(Request $request)
    {
        $grade_id = null;
        $transaction_amount = data_already_exists;
        if ($request->grade_id != "Please choose"){
            $grade_id =$request->grade_id;
        }

        if (empty($grade_id)){
            $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id])->first();
        }else{
            $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id,'grade_id'=>$grade_id])->first();
        }

        if (empty($val_transaction_amount)) {
            $transaction_amount = new transaction_amount;

            $transaction_amount->app_type = $request->app_type;

            $transaction_amount->card_type = $request->card_id;

            $transaction_amount->grade_id = $grade_id;

            $transaction_amount->transaction_amount = $request->transaction_amount;

            $transaction_amount->save();
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
//        foreach ($limit_schedule as $f){
//            if ($f->start_at == time08){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time09']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time08'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time09){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time09']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time09'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time10){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time10']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time10'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time11){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time11']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time11'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time12){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time12']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time12'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time13){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time13']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time13'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time14){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time14']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time14'].'</td>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time15){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time15']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time15'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time16){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time16']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time16'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }else if ($f->start_at == time17){
//                $time = $f->start_at.' - '.$f->end_at;
//                $data .=' <tr>';
//                if ($f->amount == $time_schedule['time17']) {
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
//                }else{
//                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.$f->start_at.'">&ensp;&ensp;&ensp;' . $time . '</td>';
//                }
//                $data .='<td>'.$time_schedule['time17'].'</td>>';
//                $data .='<td>'.$f->amount.'</td>>';
//                $data .='</tr>';
//            }
//        }

        return $data;
    }
    protected function limit_schedule()
    {
        $schedule_limit = schedule_limit::where(["status"=>aktif])->get();
        return $schedule_limit;
    }

    protected function time_schedule($eventDate){
//        $time08 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','08:00:00')
//            ->count();
//        $time09 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','09:00:00')
//            ->count();
//        $time10 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','10:00:00')
//            ->count();
//        $time11 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','11:00:00')
//            ->count();
//        $time12 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','12:00:00')
//            ->count();
//        $time13 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','13:00:00')
//            ->count();
//        $time14 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','14:00:00')
//            ->count();
//        $time15 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','15:00:00')
//            ->count();
//        $time16 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','16:00:00')
//            ->count();
//        $time17 = booking_schedule::where(['status_app'=>book_appointment])
//            ->whereDate('appointment_date','=',$eventDate)
//            ->whereTime('appointment_date','=','17:00:00')
//            ->count();
//
//        $data = array('time08'=>$time08,'time09'=>$time09,'time10'=>$time10,'time11'=>$time11,'time12'=>$time12,'time13'=>$time13,'time14'=>$time14,'time15'=>$time15,'time16'=>$time16,'time17'=>$time17);
        $data = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->get();
        return $data;
    }


}
