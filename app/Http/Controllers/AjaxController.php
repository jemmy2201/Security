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
use App\Dateholiday;
use App\activation_phones;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Artisan;
Use Storage;
use DateTime;
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
        $data = booking_schedule::where(['nric' => Auth::user()->nric])->first();
        if (!empty($data)){
            $new = false;
            $Datareplacement = booking_schedule::where(['nric' => Auth::user()->nric,'status_app'=>payment])->first();
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

        $data = booking_schedule::where(['nric' => Auth::user()->nric,'app_type' => news])->get();
        foreach ($data as $index => $f){
            if($f->card_id == so_app){
                if ($f->Status_app == null){
                    $so_app = false;
                }else{
                    $so_app = true;
                }
            }else{
                $so_app = true;
            }

            if ($f->card_id == avso_app){
                if ($f->Status_app == null){
                    $avso_app = false;
                }else{
                    $avso_app = true;
                }
            }else{
                $avso_app = true;
            }

            if ($f->card_id == pi_app){
                if ($f->Status_app == null){
                    $pi_app = false;
                }else{
                    $pi_app = true;
                }
            }else{
                $pi_app = true;
            }

            if ($f->Status_app == null){
//                if ($f->card_id == so_app ){
//                    $so_app = true;
//                }elseif ($f->card_id == avso_app){
//                    $avso_app = true;
//                }elseif ($f->card_id == pi_app){
//                    $pi_app = true;
//                }
            }elseif ($f->Status_app == draft || $f->Status_app == submitted){
                if ($f->card_id == so_app && $f->Status_app == draft || $f->Status_app == submitted){
                    $so_app = true;
                }elseif ($f->card_id == avso_app && $f->Status_app == draft || $f->Status_app == submitted){
                    $avso_app = true;
                }elseif ($f->card_id == pi_app && $f->Status_app == draft || $f->Status_app == submitted){
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
        $cek_booking_schedule = booking_schedule::where(['status_app'=>draft])
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
            $history_login[$index]->nric = secret_decode($f->nric);
            if (!empty($f->time_login_at)){
                $history_login[$index]->time_login_at = Carbon::createFromFormat('Y-m-d', $f->time_login_at)->format('d-m-Y');
            }else{
                $history_login[$index]->time_login_at = null;
            }
        }

        return Datatables::of($history_login)->addColumn('action', function($row){

            $btn = '<a href="#" class="photo btn btn-primary btn-sm"><i class="fas fa-image"  style="cursor: pointer;"></i></a>';

            return $btn;
        })->make(true);
    }
    public function security_employees()
    {
        $security_employees = sertifikat::select('sertifikats.id','users.nric','users.name','users.email','sertifikats.app_type','sertifikats.card_id','sertifikats.grade_id','sertifikats.expired_date','users.photo')
                             ->leftjoin('users', 'sertifikats.nric', '=', 'users.nric')->leftjoin('grades', 'sertifikats.grade_id', '=', 'grades.id')->get();
        foreach($security_employees as $key => $f){
//                foreach (json_decode($f->grade_id) as $g){
//                      $grade = grade::where(['id'=>$g])->first();
//                      $grade_name[] = $grade->type;
//                }
            if ($f->grade_id == so){
                $grade_id = "SO";
            }elseif ($f->grade_id == sso){
                $grade_id = "SSO";
            }elseif ($f->grade_id == ss){
                $grade_id = "SS";
            }elseif ($f->grade_id == sss){
                $grade_id = "SSS";
            }elseif ($f->grade_id == cso){
                $grade_id = "CSO";
            }else{
                $grade_id = "-";
            }
            $security_employees[$key]->name_grade = $grade_id;
            $security_employees[$key]->nric = secret_decode($f->nric);
            $security_employees[$key]->expired_date = Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('d-m-Y');
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
    public function data_holiday()
    {
        $Holiday = Dateholiday::get();
        return Datatables::of($Holiday)->addColumn('action', function($row){

            $btn = '<a href="#" class="editor_edit btn btn-primary btn-sm">Edit</a>
                    <a href="#" class="delete btn btn-primary btn-sm">Delete</a>';

            return $btn;

        })->make(true);

    }
    public function data_grade()
    {
        $data_grade = User::join('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->whereNull('role')
//            ->whereNull('booking_schedules.app_type')
            ->get();
        foreach ($data_grade as $index =>$f){
            $data_grade[$index]->nric = secret_decode($f->nric);
        }
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
            $gst[$index]->create_date = Carbon::createFromFormat('Y-m-d H:i:s', $f->created_at)->format('d-m-Y');
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
    public function insert_holiday(Request $request)
    {
        $holiday = data_already_exists;

        $cek_data = Dateholiday::whereDate('date','=',$request->date)->count();
        if ($cek_data == 0){

            $holiday = new Dateholiday();

            $holiday->date = $request->date;

            $holiday->name_holiday = $request->name_holiday;

            $holiday->time_work = $request->time_work;

            $holiday->save();

        }

        $holiday = array(
            "error"=>$holiday,
            "data"=>save,
        );
        return $holiday;
    }
    public function update_holiday(Request $request)
    {
        $holiday = data_already_exists;

        $holiday = Dateholiday::find($request->id);

        $holiday->name_holiday = $request->name_holiday;

        $holiday->time_work = $request->time_work;

        $holiday->save();

        $holiday = array(
            "error"=>$holiday,
            "data"=>update,
        );
        return $holiday;
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
            $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id,'grade_type'=>$grade_id])->first();
        }

        if (empty($val_transaction_amount)) {
            if (!empty($grade_id)) {
//                if ($grade_id == so){
//                    $grade_id = "SO";
//                }elseif ($grade_id == sso){
//                    $grade_id = "SSO";
//                }elseif ($grade_id == ss){
//                    $grade_id = "SS";
//                }elseif ($grade_id == sss){
//                    $grade_id = "SSS";
//                }elseif ($grade_id == cso){
//                    $grade_id = "CSO";
//                }

                $grades = grade::where(['type'=>$grade_id])->get();
                foreach ($grades as $index => $f){
                    $val_transaction_amount = transaction_amount::where(['app_type'=>$request->app_type,'card_type'=>$request->card_id,'grade_id'=>$f->id])->first();
                    if (empty($val_transaction_amount)){
//                        if ($f->type == "SO"){
//                            $grade_type = 1;
//                        }elseif ($f->type == "SSO"){
//                            $grade_type = 2;
//                        }elseif ($f->type == "SS"){
//                            $grade_type = 3;
//                        }elseif ($f->type == "SSS"){
//                            $grade_type = 4;
//                        }elseif ($f->type == "CSO"){
//                            $grade_type = 5;
//                        }
                        $transaction_amount = new transaction_amount;

                        $transaction_amount->app_type = $request->app_type;

                        $transaction_amount->card_type = $request->card_id;

                        $transaction_amount->grade_id = $f->id;

                        $transaction_amount->transaction_amount = $request->transaction_amount;

                        $transaction_amount->grade_type = $f->type;

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
                    $user = User::where(['nric'=>$g->nric])->first();
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

        return Excel::download(new BookingScheduleExport, 'appointment.csv');

    }

    public function download_template_grade(){

        return Excel::download(new UpgradeGradeExport, 'template_grade.csv');

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
    public function delete_holiday(Request $request)
    {
        $data = Dateholiday::find($request->id);

        $data->delete();

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
        $data_old = sertifikat::where(['card_id'=>$request->card_id,'nric' => Auth::user()->nric])->latest('created_at')->first();
        if ($request->app_type == news) {
            $delete_process = booking_schedule::where(['id'=>$request->id,'nric' => Auth::user()->nric])->first();
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
                        'nric' => Auth::user()->nric,
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
                        'nric' => Auth::user()->nric,
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
                'array_grade' => $row[8],
                'status_app' => $row[9],
                'declaration_date' => $row[10],
                'transfer_date' => $row[11],
                'expiry_date' => $row[12],
            ];
        }
        foreach ($arr as $e){
            if ($e['nric'] != 'nric'){

                $users = User::where(['nric'=>secret_encode($e['nric'])])->first();
                $count_users = User::count();

                $format = 'd/m/Y';
                $format_expired_date = DateTime::createFromFormat($format, $e['expiry_date']);
                $cek_format_expired_date = $format_expired_date && $format_expired_date->format($format) === $e['expiry_date'];
                if (empty($e['expiry_date'])){
                    $expired_date = null;
                }elseif($cek_format_expired_date == true) {
                    $expired_date = $e['expiry_date'];
                } else {
                    $expired_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($e['expiry_date'])->format('d/m/Y');
                }

                $format = 'd/m/Y';
                $format_declaration_date = DateTime::createFromFormat($format, $e['declaration_date']);
                $cek_format_declaration_date = $format_declaration_date && $format_declaration_date->format($format) === $e['declaration_date'];

                if (empty($e['declaration_date'])){
                    $declaration_date = null;
                }elseif($cek_format_declaration_date == true) {
                    $declaration_date = $e['declaration_date'];
                }else{
//                    $declaration_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($e['declaration_date'])->format('d/m/Y');
                    $declaration_date = $e['declaration_date'];
                }

                $format = 'd/m/Y H:i:s';
                $format_transfer_date = DateTime::createFromFormat($format, $e['transfer_date']);
                $cek_format_transfer_date = $format_transfer_date && $format_transfer_date->format($format) === $e['transfer_date'];

                if (empty($e['transfer_date'])){
                    $transfer_date = null;
                }elseif($cek_format_transfer_date == true) {
                    $transfer_date = $e['transfer_date'];
                } else {
//                    $transfer_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($e['transfer_date'])->format('d/m/Y H:i:s');
                    $transfer_date = $e['transfer_date'];

                }

                if (strtoupper($e['status_app']) == completed ){
                    $status_app = strtoupper($e['status_app']);
                }else{
                    $status_app = $e['status_app'];
                }
                if (empty($users)){
                    $nric = str_replace(' ', '', $e['nric']);
                    // insert table users
                    $New_users = new User();

                    $New_users->nric = secret_encode($nric);

                    $New_users->name = $e['name'];

                    $New_users->mobileno = $e['mobile'];

                    $New_users->homeno = $e['home'];

                    $New_users->email = 'email'.$count_users.'@admin.com';

                    $New_users->password = Hash::make('123123');

                    $New_users->save();
                    // End insert table users

                    // insert table boooking
                    $booking_schedule = new booking_schedule;

                    $booking_schedule->app_type = $e['app_type'];

                    $booking_schedule->card_id = $e['card_type'];

                    $booking_schedule->passid = $e['passid'];

                    $booking_schedule->grade_id = $e['grade'];

                    $booking_schedule->array_grade = $e['array_grade'];

                    $booking_schedule->Status_app = $status_app;

                    $booking_schedule->trans_date = $transfer_date;

                    $booking_schedule->declaration_date = $declaration_date;

                    $booking_schedule->expired_date = $expired_date;

                    $booking_schedule->nric = $New_users->nric;

                    $booking_schedule->save();
                    // End insert table boooking

                }else{

                    // update table user
                    $nric = str_replace(' ', '', $e['nric']);

                    $Update_users = User::find($users->id);

                    $Update_users->nric = secret_encode($nric);

                    $Update_users->name = $e['name'];

                    $Update_users->mobileno = $e['mobile'];

                    $Update_users->homeno = $e['home'];

                    $Update_users->save();
                    // End update table user
                    // update table booking

                    $ID_booking = booking_schedule::where(['nric' => secret_encode($e['nric']),"card_id"=>$e['card_type']])->first();

                    if (!empty($ID_booking)) {

                        $update_booking_schedule = booking_schedule::find($ID_booking->id);

                        $update_booking_schedule->app_type = $e['app_type'];

                        $update_booking_schedule->card_id = $e['card_type'];

                        $update_booking_schedule->grade_id = $e['grade'];

                        $update_booking_schedule->passid = $e['passid'];

                        $update_booking_schedule->array_grade = $e['array_grade'];

                        $update_booking_schedule->Status_app = $status_app;

                        $update_booking_schedule->declaration_date = $declaration_date;

                        $update_booking_schedule->trans_date = $transfer_date;

                        $update_booking_schedule->expired_date = $expired_date;

                        $update_booking_schedule->save();
                    }else{
                        // insert table boooking
                        $booking_schedule = new booking_schedule;

                        $booking_schedule->app_type = $e['app_type'];

                        $booking_schedule->card_id = $e['card_type'];

                        $booking_schedule->passid = $e['passid'];

                        $booking_schedule->grade_id = $e['grade'];

                        $booking_schedule->array_grade = $e['array_grade'];

                        $booking_schedule->Status_app = $status_app;

                        $booking_schedule->declaration_date = $declaration_date;

                        $booking_schedule->trans_date = $transfer_date;

                        $booking_schedule->expired_date = $expired_date;

                        $booking_schedule->nric = $users->nric;

                        $booking_schedule->save();
                        // End insert table boooking
                    }
                    // End update table booking

                }

                if (strtoupper($e['status_app']) == completed && !empty($expired_date) && !empty($declaration_date)){
                    $data = booking_schedule::leftjoin('users', 'booking_schedules.nric', '=', 'users.nric')
                        ->where(['users.nric'=>secret_encode($e['nric']),'card_id'=>$e['card_type']])
                        ->first();

                    if (!empty($data)) {
                        $cek_setifikat = sertifikat::where(['nric'=>secret_encode($e['nric']),'card_id'=>$e['card_type'],'receiptNo'=>$data->receiptNo])->first();
                        if (!empty($data->transaction_amount_id)) {
                            $data_transcation_amount = transaction_amount::find($data->transaction_amount_id);
                            $Transaction_amount = $data_transcation_amount->transaction_amount;
                        }else{
                            $Transaction_amount = null;
                        }
                        if (empty($cek_setifikat)){

                            $sertifikat = new sertifikat();

                            $sertifikat->app_type = $data->app_type;

                            $sertifikat->card_id = $data->card_id;

                            $sertifikat->grade_id = $data->grade_id;

                            $sertifikat->array_grade = $data->array_grade;

                            $sertifikat->bsoc = $data->bsoc;

                            $sertifikat->ssoc = $data->ssoc;

                            $sertifikat->sssc = $data->sssc;

                            $sertifikat->declaration_date = $data->declaration_date;

                            $sertifikat->gst                = $data->gst_id;

                            $sertifikat->trans_date = $data->trans_date;

                            $sertifikat->expired_date = $data->expired_date;

                            $sertifikat->appointment_date = $data->appointment_date;

                            $sertifikat->time_start_appointment = $data->time_start_appointment;

                            $sertifikat->time_end_appointment = $data->time_end_appointment;

                            $sertifikat->transaction_amount   = $Transaction_amount;

                            $sertifikat->paymentby = $data->paymentby;

                            $sertifikat->status_payment = $data->status_payment;

                            $sertifikat->grand_total = $data->grand_total;

                            $sertifikat->receiptNo = $data->receiptNo;

                            $sertifikat->status_app = $data->Status_app;

                            $sertifikat->status_payment = $data->status_payment;

                            $sertifikat->nric = $data->nric;

                            $sertifikat->passid = $data->passid;

                            $sertifikat->passexpirydate = $data->passexpirydate;

                            $sertifikat->resubmission_date = $data->resubmission_date;

                            $sertifikat->netstxnref = $data->netstxnref;

                            $sertifikat->txnrand = $data->txnrand;

                            $sertifikat->save();
                        }

                    }
                }

            }



        }
        return $data;
    }
    public function cek_limit_schedule(Request $request)
    {
        return $this->view_time_schedule($this->time_schedule(Carbon::parse($request->eventDate)->toDateString()),$this->limit_schedule(),Carbon::parse($request->eventDate)->toDateString());
    }
    public function check_activation(Request $request)
    {
        $activation = activation_phones::where(['activation'=>$request->activation,'nric'=> Auth::user()->nric])
                      ->first();
        if (!empty($activation)) {
            if ($activation->status == false) {
                $respon = succes;
                $update_activation_phones = activation_phones::find($activation->id);

                $update_activation_phones->status = succes;

                $update_activation_phones->save();
            } else {
                $respon = already_used;
            }
        }else{
            $respon = failed;
        }
        return $respon;
    }
    public function sent_activation_phone(Request $request)
    {
        $activation = $this->create_activation_phone();
        if(strlen($request->phone) == 10){
            if ($request->phone[0] == "6" && $request->phone[1] == "5"){
                $phone = $request->phone;
            }else{
                $phone = not_number_singapore;
            }
        }elseif (strlen($request->phone) == 8){
            if ($request->phone[0] == "9" || $request->phone[0] == "8"){
                $phone = "65".$request->phone;
            }else{
                $phone = not_number_singapore;
            }
        }else{
            $phone = wrong_format_number;
        }
        if ($phone[0] == "6" || $phone[1] == "5") {
            if (Auth::user()->mobileno == $phone){
                $response = same_number_phone;
            }else {
                $response = $this->gw_send_sms($activation, $phone);
                if ($response) {
                    $new_activation = new activation_phones();

                    $new_activation->activation = $activation;

                    $new_activation->status = false;

                    $new_activation->nric = Auth::user()->nric;

                    $new_activation->save();

                }
            }
        }else{
            $response = $phone;
        }
        return $response;
    }
    public function create_activation_phone()
    {
        $digits = 4;
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
    public function gw_send_sms($activation,$sms_to)
    {
        $sms_msg = "Use OTP ".$activation." to verify your phone number";
        $query_string = "api.aspx?apiusername=".env('username_gateway_sms')."&apipassword=".env('password_gateway_sms');
        $query_string .= "&senderid=".rawurlencode(env('sms_from_gateway_sms'))."&mobileno=".rawurlencode($sms_to);
        $query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";
        $url = env('url_gateway_sms').$query_string;
        $fd = @implode ('', file ($url));
        if ($fd)
        {
            if ($fd > 0) {
//                Print("MT ID : " . $fd);
                $respon = true;
            }
            else {
//                print("Please refer to API on Error : " . $fd);
                $respon = false;
            }
        }
        else
        {
            // no contact with gateway
//            $respon = "fail";
            $respon = false;
        }
        return $respon ;
    }
    protected  function view_time_schedule($time_schedule,$limit_schedule,$eventDate){
        $data ='';
        foreach ($limit_schedule as $key => $ls) {
            $data_schedule = booking_schedule::whereIn('Status_app', [draft, submitted,resubmission,Resubmitted])
                ->whereDate('appointment_date','=',$eventDate)
                ->where(['time_start_appointment'=>$ls->start_at,'time_end_appointment'=>$ls->end_at])
                ->get();

            $dateHoliday = Dateholiday::whereDate('date','=',$eventDate)->first();
            $setifikat = sertifikat::whereIn('status_app', [draft, submitted])
                ->whereDate('appointment_date','=',$eventDate)
                ->where(['time_start_appointment'=>$ls->start_at,'time_end_appointment'=>$ls->end_at])
                ->count();
            if ($data_schedule->count() > 0 && $data_schedule[0]->Status_app == resubmission){
                $limit_schedule[$key]->valid_resubmission = true;
                $limit_schedule[$key]->valid_resubmission_date =  $data_schedule[0]->time_start_appointment  . '-' . $data_schedule[0]->time_end_appointment ;
            }

            if ($setifikat > 0 ){
                $limit_schedule[$key]->number_schedule = $data_schedule->count() + $setifikat;
            }else{
                $limit_schedule[$key]->number_schedule = $data_schedule->count();
            }
            $limit_schedule[$key]->half = false;
            if (!empty($dateHoliday) && $ls->start_at == half_1 ){
                $limit_schedule[$key]->half = true;
            }elseif(!empty($dateHoliday) &&  $ls->start_at == half_2 ){
                $limit_schedule[$key]->half = true;
            }elseif(!empty($dateHoliday) && $ls->start_at == half_3 ){
                $limit_schedule[$key]->half = true;
            }elseif(!empty($dateHoliday) && $ls->start_at == half_4){
                $limit_schedule[$key]->half = true;
            }
        }
//        die(print_r($limit_schedule));

        foreach ($limit_schedule as $key => $ls ) {
            $time = $ls->start_at . '-' . $ls->end_at;
            if ($ls->half != true) {
                if (!empty($ls->number_schedule)) {
                    if ($ls->valid_resubmission == true && $time == $ls->valid_resubmission_date){
                        // resubmission
                        $data .= ' <tr style="background-color:#FF0000">';
                        if ($ls->amount == $ls->number_schedule) {
                            $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                        } else {
                            if ($eventDate == Carbon::today()->toDateString() && $ls->start_at < Carbon::now()->toTimeString()) {
                                $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                            } else {
                                $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '" checked="checked">&ensp;&ensp;&ensp;' . $time . '</td>';
                            }
                        }
                        $data .= '<td>' . $ls->number_schedule . '</td>';
                        $data .= '<td>' . $ls->amount . '</td>>';
                        $data .= '</tr>';
                        // End resubmission
                    }else {
                        $data .= ' <tr>';
                        if ($ls->amount == $ls->number_schedule) {
                            $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                        } else {
                            if ($eventDate == Carbon::today()->toDateString() && $ls->start_at < Carbon::now()->toTimeString()) {
                                $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                            } else {
                                $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '">&ensp;&ensp;&ensp;' . $time . '</td>';
                            }
                        }
                        $data .= '<td>' . $ls->number_schedule . '</td>';
                        $data .= '<td>' . $ls->amount . '</td>>';
                        $data .= '</tr>';
                    }
                } else {
                    $time = $ls->start_at . '-' . $ls->end_at;
                    $data .= ' <tr>';
                    if ($eventDate == Carbon::today()->toDateString() && $ls->start_at < Carbon::now()->toTimeString()) {
                        $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                    } else {
                        $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="' . $ls->id . '">&ensp;&ensp;&ensp;' . $time . '</td>';
                    }
                    $data .= '<td>0</td>';
                    $data .= '<td>' . $ls->amount . '</td>>';
                    $data .= '</tr>';
                }
            }else{
                $data .= '<td> <input class="form-check-input" type="radio" name="limit_schedule_id" id="limit_schedule_id" value="'.$ls->id.'" disabled>&ensp;&ensp;&ensp;' . $time . '</td>';
                if (!empty($ls->number_schedule)) {
                    $data .= '<td>' . $ls->number_schedule . '</td>';
                }else{
                    $data .= '<td>0</td>';
                }
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
        $data = booking_schedule::whereIn('status_app', [draft, submitted])
            ->whereDate('appointment_date','=',$eventDate)
            ->get();
        return $data;
    }


}
