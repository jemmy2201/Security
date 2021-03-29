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
            if (Carbon::today()->toDateString() > Carbon::parse($data->expired_date)->toDateString()){
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
        foreach ($limit_schedule as $f){
            if ($f->start_at == time09){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time09']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time09 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time09.'">&ensp;&ensp;&ensp;' . time09 . '</td>';
                }
                $data .='<td>'.$time_schedule['time09'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time10){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time10']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time10 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time10.'">&ensp;&ensp;&ensp;' . time10 . '</td>';
                }
                $data .='<td>'.$time_schedule['time10'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time11){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time11']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time11 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time11.'">&ensp;&ensp;&ensp;' . time11 . '</td>';
                }
                $data .='<td>'.$time_schedule['time11'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time12){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time12']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time12 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time12.'">&ensp;&ensp;&ensp;' . time12 . '</td>';
                }
                $data .='<td>'.$time_schedule['time12'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time13){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time13']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time13 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time13.'">&ensp;&ensp;&ensp;' . time13 . '</td>';
                }
                $data .='<td>'.$time_schedule['time13'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time14){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time14']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time14 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time14.'">&ensp;&ensp;&ensp;' . time14 . '</td>';
                }
                $data .='<td>'.$time_schedule['time14'].'</td>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time15){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time15']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time15 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time15.'">&ensp;&ensp;&ensp;' . time15 . '</td>';
                }
                $data .='<td>'.$time_schedule['time15'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }else if ($f->start_at == time16){
                $data .=' <tr>';
                if ($f->amount == $time_schedule['time16']) {
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule"  disabled>&ensp;&ensp;&ensp;' . time16 . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="time_schedule" id="time_schedule" value="'.time16.'">&ensp;&ensp;&ensp;' . time16 . '</td>';
                }
                $data .='<td>'.$time_schedule['time16'].'</td>>';
                $data .='<td>'.$f->amount.'</td>>';
                $data .='</tr>';
            }
        }
        return $data;
    }
    protected function limit_schedule()
    {
        $schedule_limit = schedule_limit::get();

        return $schedule_limit;
    }

    protected function time_schedule($eventDate){
        $time09 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','09:00:00')
            ->count();
        $time10 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','10:00:00')
            ->count();
        $time11 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','11:00:00')
            ->count();
        $time12 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','12:00:00')
            ->count();
        $time13 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','13:00:00')
            ->count();
        $time14 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','14:00:00')
            ->count();
        $time15 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','15:00:00')
            ->count();
        $time16 = booking_schedule::where(['status_app'=>book_appointment])
            ->whereDate('appointment_date','=',$eventDate)
            ->whereTime('appointment_date','=','16:00:00')
            ->count();

        $data = array('time09'=>$time09,'time10'=>$time10,'time11'=>$time11,'time12'=>$time12,'time13'=>$time13,'time14'=>$time14,'time15'=>$time15,'time16'=>$time16);

        return $data;
    }


}
