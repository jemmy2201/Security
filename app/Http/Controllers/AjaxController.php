<?php

namespace App\Http\Controllers;

use App\Exports\BookingScheduleExport;
use App\Exports\UpgradeGradeExport;
use App\grade;
use App\gst;
use App\sertifikat;
use App\User;
use Illuminate\Http\Request;
use App\booking_schedule;
use App\schedule_limit;
use App\transaction_amount;
use App\Backup_booking_schedule;
use App\Backup_users;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Artisan;
Use Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
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
    public function cek_card_type()
    {
        $so_app     = false;
        $avso_app   = false;
        $pi_app     = false;

        $data = booking_schedule::where(['user_id'=>Auth::id()])->get();
        foreach ($data as $index => $f){
            if ($f->status_app == null){
                if ($f->card_id == so_app ){
                    $so_app = true;
                }elseif ($f->card_id == avso_app){
                    $avso_app = true;
                }elseif ($f->card_id == pi_app){
                    $pi_app = true;
                }
            }else{
                if ($f->card_id == so_app  && $f->app_type == replacement || $f->app_type == renewal ){
                    $so_app = true;
                }elseif ($f->card_id == avso_app && $f->app_type == replacement || $f->app_type == renewal){
                    $avso_app = true;
                }elseif ($f->card_id == pi_app && $f->app_type == replacement || $f->app_type == renewal){
                    $pi_app = true;
                }
            }
        }
        $data = array('so_app'=>$so_app,'avso_app'=>$avso_app,'pi_app'=>$pi_app);

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
        foreach ($history_login as $index =>$f){
            $history_login[$index]->time_login_at = Carbon::createFromFormat('Y-m-d', $f->time_login_at)->format('d-m-Y');
        }

        return Datatables::of($history_login)->addColumn('action', function($row){

            $btn = '<a href="#" class="photo btn btn-primary btn-sm"><i class="fas fa-image"  style="cursor: pointer;"></i></a>';

            return $btn;
        })->make(true);
    }
    public function security_employees()
    {
        $security_employees = sertifikat::select('sertifikats.id','users.nric','users.name','users.email','sertifikats.app_type','sertifikats.card_id','sertifikats.grade_id','sertifikats.expired_date','users.photo')
                             ->leftjoin('users', 'sertifikats.user_id', '=', 'users.id')->leftjoin('grades', 'sertifikats.grade_id', '=', 'grades.id')->get();
        foreach($security_employees as $key => $f){
//                foreach (json_decode($f->grade_id) as $g){
//                      $grade = grade::where(['id'=>$g])->first();
//                      $grade_name[] = $grade->type;
//                }
            if ($f->grade_id == so){
                $grade_id = "SO";
            }elseif ($f->grade_id == sso){
                $grade_id = "SSO";
            }elseif ($f->grade_id == sso){
                $grade_id = "SSS";
            }else{
                $grade_id = "-";
            }
            $security_employees[$key]->name_grade = $grade_id;
            $security_employees[$key]->expired_date = Carbon::createFromFormat('Y-m-d h:i:s', $f->expired_date)->format('d-m-Y');
//            $security_employees[$key]->count_grade = count($grade_name);
        }
        return Datatables::of($security_employees)->addColumn('action', function($row){

            $btn = '<a href="#" class="photo btn btn-primary btn-sm"><i class="fas fa-image"  style="cursor: pointer;"></i></a>';

            return $btn;
        })->make(true);
    }
    public function data_price()
    {
        $transaction_amount = DB::select('select DISTINCT grade_type,app_type,card_type,grade_type,transaction_amount from transaction_amounts ');
        foreach ($transaction_amount as $index =>$f){
            $data = transaction_amount::where(['app_type'=>$f->app_type,'card_type'=>$f->card_type,'grade_type'=>$f->grade_type])->first();
            $transaction_amount[$index]->id = $data->id;
        }
        return Datatables::of($transaction_amount)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>';

            return $btn;

        })->make(true);

    }
    public function data_grade()
    {
        $data_grade = User::leftjoin('booking_schedules', 'users.id', '=', 'booking_schedules.user_id')
            ->whereNull('role')
            ->get();
        return Datatables::of($data_grade)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>';

            return $btn;

        })->make(true);

    }
    public function data_course()
    {
        $data = grade::whereNull('delete_soft')->get();

        return Datatables::of($data)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>
                    <a href="#" class="delete btn btn-primary btn-sm">Delete</a>';

            return $btn;

        })->make(true);

    }
    public function data_gst()
    {
        $gst = gst::get();
        foreach ($gst as $index =>$f){
            $gst[$index]->create_date = Carbon::createFromFormat('Y-m-d h:i:s', $f->created_at)->format('d-m-Y');
        }
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
                        if ($f->type == "SO"){
                            $grade_type = 1;
                        }elseif ($f->type == "SSO"){
                            $grade_type = 2;
                        }elseif ($f->type == "SSS"){
                            $grade_type = 3;
                        }
                        $transaction_amount = new transaction_amount;

                        $transaction_amount->app_type = $request->app_type;

                        $transaction_amount->card_type = $request->card_id;

                        $transaction_amount->grade_id = $f->id;

                        $transaction_amount->transaction_amount = $request->transaction_amount;

                        $transaction_amount->grade_type = $grade_type;

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
        if (!empty($request->grade_type)){
//            $transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_type,'grade_type'=>$request->grade_type]);
//
//            $transaction_amount->transaction_amount = $request->transaction_amount;
//
//            $transaction_amount->save();
            $transaction_amount = DB::table('transaction_amounts')
                ->where(['app_type'=>$request->app_type,'card_type'=>$request->card_type,'grade_type'=>$request->grade_type])
                ->update(['transaction_amount' => $request->transaction_amount]);
        }else{
            $transaction_amount = transaction_amount::find($request->transaction_amounts_id);

            $transaction_amount->transaction_amount = $request->transaction_amount;

            $transaction_amount->save();
        }
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

    public function download_template_grade(){

        return Excel::download(new UpgradeGradeExport, 'template_grade.xlsx');

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
    public function restoring_table(Request $request)
    {
        return Artisan::call("backup:restore");
    }
    public function add_course(Request $request)
    {
        $cek_data = grade::where(['name'=>$request->name,'type'=>$request->type])->first();
        $data =array(
            'error' => true,
            'data' => $cek_data
        );
        if (empty($cek_data)){
            $data = new grade();

            $data->card_id = so_app;

            $data->name = $request->name;

            $data->type = $request->type;

            $data->bsoc = default_bsoc_ssoc_ssc;

            $data->ssoc = default_bsoc_ssoc_ssc;

            $data->sssc = default_bsoc_ssoc_ssc;

            $data->created_by = Auth::user()->name;

            $data->save();

            $data =array(
                'error' => false,
                'data' => $data
            );
        }

        return $data;
    }
    public function update_course(Request $request)
    {
        $data = grade::find($request->id);

        $data->name = $request->name;

        $data->type = $request->type;

        $data->save();
        if ($data){
            $data = array(
                "error" => false,
                "data"  => $data
            );
        }
        return $data;
    }

    public function delete_course(Request $request)
    {
        $data = grade::find($request->id);

        $data->delete_soft = delete_soft;

        $data->save();

        if ($data){
            $data = array(
                "error" => false,
                "data"  => $data
            );
        }
        return $data;
    }
    public function delete_process(Request $request)
    {
        $data = null;
        $data_old = sertifikat::where(['card_id'=>$request->card_id,'user_id'=>Auth::id()])->latest('created_at')->first();
        if ($request->app_type == news) {
            $delete_process = booking_schedule::where(['id'=>$request->id,'user_id'=>Auth::id()])->first();
            if ($delete_process != null) {
                $delete_process->delete();
                $data = array(
                    "error" => false,
                    "data" => $delete_process
                );
            }
        }elseif ($request->app_type == renewal){
            if($data_old != null){
                $booking_schedule = booking_schedule::where(['id'=>$request->id,])
                    ->update([
                        'app_type' => $data_old->app_type,
                        'card_id' => $data_old->card_id,
                        'grade_id' => $data_old->grade_id,
                        'declaration_date' => $data_old->declaration_date,
                        'trans_date' =>  $data_old->trans_date,
                        'appointment_date' => $data_old->appointment_date,
                        'time_start_appointment' => $data_old->time_start_appointment,
                        'time_end_appointment' => $data_old->time_end_appointment,
                        'status_app' => payment,
                        'paymentby' => $data_old->paymentby,
                        'receiptNo' => $data_old->receiptNo,
                        'status_payment' => $data_old->status_payment,
                        'array_grade' => $data_old->array_grade,
                        'bsoc' => $data_old->bsoc,
                        'ssoc' => $data_old->ssoc,
                        'sssc' => $data_old->sssc,
                        'user_id' => Auth::id(),
                    ]);
            }

        }else{
            if($data_old != null){
                $booking_schedule = booking_schedule::where(['id'=>$request->id,])
                    ->update([
                        'app_type' => $data_old->app_type,
                        'card_id' => $data_old->card_id,
                        'grade_id' => $data_old->grade_id,
                        'declaration_date' => $data_old->declaration_date,
                        'trans_date' =>  $data_old->trans_date,
                        'expired_date' => $data_old->expired_date,
                        'appointment_date' => $data_old->appointment_date,
                        'time_start_appointment' => $data_old->time_start_appointment,
                        'time_end_appointment' => $data_old->time_end_appointment,
                        'status_app' => payment,
                        'paymentby' => $data_old->paymentby,
                        'receiptNo' => $data_old->receiptNo,
                        'status_payment' => $data_old->status_payment,
                        'array_grade' => $data_old->array_grade,
                        'bsoc' => $data_old->bsoc,
                        'ssoc' => $data_old->ssoc,
                        'sssc' => $data_old->sssc,
                        'user_id' => Auth::id(),
                    ]);
            }
        }

        return $data;
    }
    public function upload_excel_grade(Request $request)
    {
        // Backup Data For restoring
        Artisan::call("backup:database");
        // End Backup Data For restoring

        $data = Excel::toArray(new BookingScheduleExport(), request()->file('upgrade_grade'));
        foreach($data[0] as $row) {
            $arr[] = [
                'nric' => $row[0],
                'name' => $row[1],
                'mobile' => $row[2],
                'home' => $row[3],
                'passid' => $row[4],
                'app_type' => $row[5],
                'card_type' => $row[6],
                'grade' => $row[7],
                'expiry_date' => $row[8],
            ];
        }
        foreach ($arr as $e){

            if ($e['nric'] != 'nric'){

                $users = User::where(['nric'=>$e['nric']])->first();
                $count_users = User::count();

                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$e['expiry_date'])) {
                    $expired_date = $e['expiry_date'];
                } else {
                    $expired_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($e['expiry_date'])->format('Y-m-d');
                }

                if (empty($users)){
                    // insert table users
                    $New_users = new User();

                    $New_users->nric = $e['nric'];

                    $New_users->name = $e['name'];

                    $New_users->mobileno = $e['mobile'];

                    $New_users->homeno = $e['home'];

                    $New_users->passid = $e['passid'];

                    $New_users->email = 'email '.$count_users;

                    $New_users->password = Hash::make('123123');

                    $New_users->save();
                    // End insert table users

                    // insert table boooking
                    $booking_schedule = new booking_schedule;

                    $booking_schedule->app_type = $e['app_type'];

                    $booking_schedule->card_id = $e['card_type'];

                    if (strtoupper($e['grade']) == "SO"){
                        $grade = so;
                    }elseif (strtoupper($e['grade']) == "SSO"){
                        $grade = sso;
                    }elseif (strtoupper($e['grade']) == "SSS"){
                        $grade = sss;
                    }else{
                        $grade = null;
                    }
                    $booking_schedule->grade_id = $grade;

                    $booking_schedule->expired_date = $expired_date;

                    $booking_schedule->user_id = $New_users->id;

                    $booking_schedule->save();
                    // End insert table boooking

                }else{
                    // update table user

                    $Update_users = User::find($users->id);

                    $Update_users->nric = $e['nric'];

                    $Update_users->name = $e['name'];

                    $Update_users->mobileno = $e['mobile'];

                    $Update_users->homeno = $e['home'];

                    $Update_users->passid = $e['passid'];

                    $Update_users->save();
                    // End update table user

                    // update table booking
                    if (strtoupper($e['grade']) == "SO"){
                        $grade = so;
                    }elseif (strtoupper($e['grade']) == "SSO"){
                        $grade = sso;
                    }elseif (strtoupper($e['grade']) == "SSS"){
                        $grade = sss;
                    }else{
                        $grade = null;
                    }


                    $ID_booking = booking_schedule::where(["user_id"=>$users->id,"card_id"=>$e['card_type']])->first();

                    if (!empty($ID_booking)) {

                        $update_booking_schedule = booking_schedule::find($ID_booking->id);

                        $update_booking_schedule->app_type = $e['app_type'];

                        $update_booking_schedule->card_id = $e['card_type'];

                        $update_booking_schedule->grade_id = $grade;

                        $update_booking_schedule->expired_date = $expired_date;

                        $update_booking_schedule->save();
                    }else{
                        // insert table boooking
                        $booking_schedule = new booking_schedule;

                        $booking_schedule->app_type = $e['app_type'];

                        $booking_schedule->card_id = $e['card_type'];

                        if (strtoupper($e['grade']) == "SO"){
                            $grade = so;
                        }elseif (strtoupper($e['grade']) == "SSO"){
                            $grade = sso;
                        }elseif (strtoupper($e['grade']) == "SSS"){
                            $grade = sss;
                        }else{
                            $grade = null;
                        }
                        $booking_schedule->grade_id = $grade;

                        $booking_schedule->expired_date = $expired_date;

                        $booking_schedule->user_id = $users->id;

                        $booking_schedule->save();
                        // End insert table boooking
                    }
                    // End update table booking

                }

            }



        }
        return $data;
    }
    public function cek_limit_schedule(Request $request)
    {
        return $this->view_time_schedule($this->time_schedule(Carbon::parse($request->eventDate)->toDateString()),$this->limit_schedule(),Carbon::parse($request->eventDate)->toDateString());
    }
    protected  function view_time_schedule($time_schedule,$limit_schedule,$eventDate){
        $data ='';
        foreach ($limit_schedule as $key => $ls) {
            $data_schedule = booking_schedule::whereIn('status_app', [book_appointment, payment])
                ->whereDate('appointment_date','=',$eventDate)
                ->where(['time_start_appointment'=>$ls->start_at,'time_end_appointment'=>$ls->end_at])
                ->get();
            $limit_schedule[$key]->number_schedule = $data_schedule->count();
        }
        foreach ($limit_schedule as $key => $ls ){
            if (!empty($ls->number_schedule)){
                $time = $ls->start_at . '-' . $ls->end_at;
                $data .= ' <tr>';
                if ($ls->amount == $ls->number_schedule ){
                    $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                }else{
                    if ($eventDate == Carbon::today()->toDateString() && $ls->start_at < Carbon::now()->toTimeString() ){
                        $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                    }else{
                        $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'">&ensp;&ensp;&ensp;' . $time . '</td>';
                    }
                }
                $data .= '<td>'.$ls->number_schedule.'</td>';
                $data .= '<td>' . $ls->amount . '</td>>';
                $data .= '</tr>';
            }else{
                $time = $ls->start_at . '-' . $ls->end_at;
                $data .= ' <tr>';
                if ($eventDate == Carbon::today()->toDateString() && $ls->start_at < Carbon::now()->toTimeString() ){
                    $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                }else{
                    $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'">&ensp;&ensp;&ensp;' . $time . '</td>';
                }
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
        $data = booking_schedule::whereIn('status_app', [book_appointment, payment])
            ->whereDate('appointment_date','=',$eventDate)
            ->get();
        return $data;
    }


}
