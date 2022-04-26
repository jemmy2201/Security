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
use App\t_grade;
use App\transaction_amount;
use App\gst;
use App\sertifikat;
use DB;
use App\Dateholiday;
use Jenssegers\Agent\Agent;
use PDF;
Use Redirect;
use Artisan;
use Illuminate\Support\Facades\Route;
use App\tbl_receiptNo;
use App\so_update_info;
use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\Promise\all;

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
        if (Auth::user()->role == admin  ) {
            return view('admin/historylogin');
        }elseif(Auth::user()->role == office){
            return view('admin/upgrade_grade');
        }
//        die(print_r(Auth::user()->nric));
        return view('home');
    }
    public function landing_page()
    {
//        die(print_r(Auth::user()->nric));

        $cek_del_schedule = booking_schedule::where(['nric' => Auth::user()->nric])->whereIn('Status_app', [draft])->get();

        // Delete data if not payment 3 month
        foreach ($cek_del_schedule as $f) {
            $cek_Month = $this->cek_month($f->appointment_date);
            if ($cek_Month == three_month) {
                $del_schedule = booking_schedule::find($f->id);
                $del_schedule->delete();
            }
        }
        // End Delete data if not payment 3 month
        $schedule = booking_schedule::where(['nric' => Auth::user()->nric])->whereNotIn('Status_app', [completed])->get();
//        $cekStatusUser = booking_schedule::where(['nric' => Auth::user()->nric])->get();

        $cekStatusUser = booking_schedule::where(['nric' => Auth::user()->nric])->orderBy('card_id', 'desc')->get();

        $sertifikat = sertifikat::where(['nric' => Auth::user()->nric])->orderBy('id', 'desc')->get();

        $new = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>news])->where('Status_app', '=', null)
            ->orderBy('card_id', 'asc')->get();
        $next_new = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>news])->where('Status_app', '=', completed)
            ->orderBy('card_id', 'asc')->get();
//        $replacement = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>news,'Status_app'=>completed])
//            ->orderBy('card_id', 'asc')->get();

        $replacement = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>replacement])
            ->where('status_payment', null)
            ->orderBy('card_id', 'asc')->get();

//        foreach ($replacement as $index => $f) {
//            if ($f->Status_draft != "0") {
//                $replacement = $replacement;
//            }else{
//                $replacement = array();
//            };
//        }



        $from_new_to_replacement = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>news,'Status_app'=>completed])
            ->orderBy('card_id', 'asc')->get();
//        if (count($replacement) == zero){
            foreach ($from_new_to_replacement as $index => $f) {
                if (Carbon::today()->toDateString() < Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d')) {
//                    $replacement = $from_new_to_replacement;
//                    $replacement = array_merge($replacement->toArray(), $from_new_to_replacement->toArray());
//                    $replacement = json_decode(json_encode($replacement), false);
                    $replacement[] = array_merge($replacement->toArray(), $f->toArray());
                    $replacement = json_decode(json_encode($replacement), false);
                }
            }
//        }


//        $before_renewal = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>replacement,'Status_app'=>completed])
//            ->orderBy('card_id', 'asc')->get();

//        $after_renewal = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>renewal,'Status_app'=>completed])
//            ->orderBy('card_id', 'asc')->get();

//        $result_renewal =  array_merge($before_renewal->toArray(), $after_renewal->toArray());
//        $renewal = json_decode(json_encode($result_renewal), FALSE);
        $renewal = array();

        $import_renewals = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>renewal])
            ->where('Status_app', null)
//            ->whereNotIn('status_payment', [paid])
            ->orderBy('card_id', 'asc')->get();
        if (count($import_renewals) != zero) {
            $renewal = array_merge($renewal, $import_renewals->toArray());
            $renewal = json_decode(json_encode($renewal), false);
        }
//        die(print_r($renewal));
        $renewals = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>renewal])
            ->where('Status_app', completed)
//            ->whereNotIn('status_payment', [paid])
            ->orderBy('card_id', 'asc')->get();

        foreach ($renewals as $index => $f) {
            if (Carbon::today()->toDateString() < Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d')) {
                if (count($replacement) == zero){
                    $replacement = array();
                }
//                $replacement = array_merge($replacement, $renewals->toArray());
//                $replacement = json_decode(json_encode($replacement), false);
                $replacement[] = array_merge($replacement, $f->toArray());
                $replacement = json_decode(json_encode($replacement), false);
            }
        }
//        die(print_r($replacement));

        foreach ($renewals as $index => $f) {
            if (Carbon::today()->toDateString() >= Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d') ) {
//                if ($f->Status_draft != "0"){
//                    if ($f->Status_app != "1") {
                        $renewal = $renewals;
//                    }else{
//                        $renewal = array();
//                    }
//                }else{
//                    $renewal = array();
//                }
            }else{
                    $renewal = array();
            }
        }
        foreach ($next_new as $index => $f) {
            if (Carbon::today()->toDateString() >= Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d')) {
                $renewal[] = array_merge($renewal, $f->toArray());
                $renewal = json_decode(json_encode($renewal), false);
            }
        }
        $grade = grade::get();
        if (Auth::user()->role == admin  ) {
            return view('admin/historylogin');
        }elseif(Auth::user()->role == office){
            return view('admin/upgrade_grade');
        }

        // card issue
        $card_issue = booking_schedule::where(['nric' => Auth::user()->nric,'card_issue'=>"Y"])->get();
        // End card issue

//        die(print_r($sertifikat->first()));
        return view('landing_page')->with(["card_issue" => $card_issue,"schedule" => $schedule, "sertifikat" => $sertifikat, "grade" => $grade,"new" => $new,
            "replacement" => $replacement, "renewal" => $renewal,"cekStatusUser" => $cekStatusUser]);
    }

    public function personaldata(Request $request)
    {
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric])->first();
        return view('personal_particular')->with(['personal' => $personal, "request" => $request]);
    }
    public function backpersonaldata(Request $request,$app_type,$card,$Status_App = false)
    {
        $request->merge(['app_type' => $app_type,'card' => $card,'Status_App' => $Status_App]);
        $update_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'app_type' => $request->app_type, 'card_id' => $request->card])
            ->update([
                'Status_draft' => null,
            ]);
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric])->first();
        return view('personal_particular')->with(['personal' => $personal, "request" => $request]);
    }

    public function backsubmission(Request $request,$app_type,$card,$Cgrades = false)
    {
        $urldecode_Cgrades = urldecode($Cgrades);
        $Cgrades = json_decode($urldecode_Cgrades);
        $Val_Cgrades = json_decode($urldecode_Cgrades);
        $request->merge(['app_type' => $app_type,'card' => $card,'Cgrades' => $Cgrades]);

        $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->first();
        $remove_grade []="";
        $temp_array_grade= json_decode($booking_schedule->array_grade);
        $array_grade []="";

        if (!is_null($booking_schedule->Status_app) && $booking_schedule->Status_app == draft) {
            foreach ($Cgrades as $f) {
                $result = array_search("on", $Cgrades);
                unset($Cgrades[$result]);
            }
        }

        if (!empty($Cgrades)) {
            if (count($Cgrades) != count($Val_Cgrades)){
                $sertifikat = sertifikat::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->first();
                if (!empty($sertifikat)) {
                    $array_grade = json_decode($sertifikat->array_grade);
                }else{
                    $array_grade = null;
                }
            }else {
                if (!empty(json_decode($booking_schedule->array_grade))) {

                    foreach ($Cgrades as $f) {
                        $result = array_search($f, json_decode($booking_schedule->array_grade));
                        unset($temp_array_grade[$result]);
                    }
                    foreach ($temp_array_grade as $f) {
                        array_unshift($array_grade, $f);
                    }
                }
                if (empty($array_grade[0])){
                    $array_grade = null;
                }
            }
//            die(print_r(json_encode(array_filter($array_grade))));

        }else{
            if (!$request->app_type == news ) {
                $sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                $array_grade = json_decode($sertifikat->array_grade);
            }
        }
//        if (!empty($array_grade)) {
//            $update_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'app_type' => $request->app_type, 'card_id' => $request->card])
//                ->update([
//                    'array_grade' => json_encode(array_filter($array_grade)),
//                    'declaration_date' => null,
//                ]);
//        }else{
//            $update_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'app_type' => $request->app_type, 'card_id' => $request->card])
//                ->update([
//                    'array_grade' => null,
//                    'declaration_date' => null,
//                ]);
//        }

        $update_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'app_type' => $request->app_type, 'card_id' => $request->card])
            ->update([
                'Status_draft' => null,
                'declaration_date' => null,
            ]);
        // param submission
        $grade = null;
        $replacement = null;
        $view_declare = null;
        $cek_grade = null;
        $data_resubmission = null;
//        // view_declare
//        if (!empty($request->Cgrade)) {
//            if ($request->app_type == replacement) {
//                $replacement = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
////                $array_grade = array_merge(json_decode($replacement->array_grade), $request->Cgrade);
//                $view_declare = $request->Cgrade;
//            } else {
//                $view_declare = $request->Cgrade;
//            }
//        }
//        // End view_declare

//        // take grade (new design)
//        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
//        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
//        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
//        if (!empty($take_grade)) {
//            foreach ($take_grades as $index => $f) {
//                if (!empty(json_decode($take_grade->array_grade))){
//                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
//                        if ($f->id == $g) {
//                            $take_grades[$index]->take_grade = true;
//                        }
//                    }
//                }
//            }
//        }
//        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
//        $take_grade_sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->latest('created_at')->first();
//        if (isset($take_grade) && isset($take_grade_sertifikat) && count(json_decode($take_grade->array_grade)) != count(json_decode($take_grade_sertifikat->array_grade))){
//            $grade_not_payment = array_diff(json_decode($take_grade->array_grade), json_decode($take_grade_sertifikat->array_grade));
//        }elseif (!empty($take_grade) && $take_grade->status_payment !=paid){
//            $grade_not_payment = json_decode($take_grade->array_grade);
//        }
//        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
//        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
//        if (!empty($take_grade)) {
//            foreach ($take_grades as $index => $f) {
//                if (!empty(json_decode($take_grade->array_grade))){
//                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
//                        if ($f->id == $g) {
//                            $take_grades[$index]->take_grade = true;
//                        }
//                    }
//                }
//                if ($request->Cgrades[0] == false || $request->app_type == news ) {
//                    if (!empty($grade_not_payment)) {
//                        foreach ($grade_not_payment as $index2 => $i) {
//                            if ($f->id == $i) {
//                                $take_grades[$index]->grade_not_payment = true;
//                                $take_grades[$index]->take_grade = false;
//                            }
//                        }
//                    }
//                }elseif(!empty($take_grade_sertifikat)  && count(json_decode($take_grade_sertifikat->array_grade)) !== count(json_decode($selected_grade->array_grade))){
//                    if (!empty($grade_not_payment)) {
//                        foreach ($grade_not_payment as $index2 => $i) {
//                            if ($f->id == $i) {
//                                $take_grades[$index]->grade_not_payment = true;
//                                $take_grades[$index]->take_grade = false;
//                            }
//                        }
//                    }
//                }
//            }
//        }
////        dd($take_grades);
//        // end take grade (new design)

        // so and avso join
        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $take_grade_sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->latest('created_at')->first();
        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();

        if (!empty($take_grade)) {
            foreach ($take_grades as $index => $f) {
                // booking schedule
                if ($f->short_value =="TR_RTT" && isset($take_grade) && $take_grade->TR_RTT == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_CSSPB" && isset($take_grade) && $take_grade->TR_CSSPB == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_CCTC" &&  isset($take_grade) &&$take_grade->TR_CCTC == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_HCTA" && isset($take_grade) && $take_grade->TR_HCTA == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_X_RAY" && isset($take_grade) && $take_grade->TR_X_RAY == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_AVSO" && isset($take_grade) && $take_grade->TR_AVSO == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                // end booking schedule

                // sertifikat
                if ($f->short_value =="TR_RTT" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_RTT == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_CSSPB" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_CSSPB == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_CCTC" &&  isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_CCTC == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_HCTA" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_HCTA == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_X_RAY" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_X_RAY == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_AVSO" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_AVSO == "YES"){
                    $take_grades[$index]->payment = true;
                }
                // end sertifikat

            }
        }
        // end so and avso join

        $t_grade = t_grade::get();
        $resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card, 'Status_app' => resubmission])->first();
        if ($request->card == so_app) {
            if ($request->app_type == renewal) {
                if (!empty($resubmission)) {
                    $data_resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                    $grade = grade::get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                } else {
                    $renewal = booking_schedule::where(['nric' => Auth::user()->nric])->leftjoin('grades', 'booking_schedules.grade_id', '=', 'grades.id')->first();
                    $grade = grade::where(['card_id' => $renewal->card_id])->get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                }
            } elseif ($request->app_type == replacement) {
                if (!empty($resubmission)) {
                    $data_resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                    $grade = grade::get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                } else {
                    $replacement = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
//                  $replacement = booking_schedule::first();
                    $grade = grade::where(['card_id' => $replacement->card_id])->get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                }
            } else {
                if (!empty($request->Cgrade)) {
                    // view declare more than 1
                    $grade = grade::get();
                    // end view declare more than 1
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();

                } else {
                    if (!empty($resubmission)) {
                        $data_resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                        $grade = grade::get();
                        $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                    } else {
                        // user cannot belong to declare
                        $grade = grade::get();
                        $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                        // End user cannot belong to declare
                    }
                }
            }
        } else {
            if ($request->app_type == replacement || $request->app_type == renewal) {
                $replacement = booking_schedule::where(['nric' => Auth::user()->nric])->first();
//                $request->merge(['card' => $replacement->card_id]);
            }
        }
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['users.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$request->card])->first();
        // End param submission

        return view('submission')->with(['take_grades' => $take_grades,'t_grade' => $t_grade,'data_resubmission' => $data_resubmission, 'resubmission' => $resubmission, 'cek_grade' => $cek_grade, 'personal' => $personal, "grade" => $grade, "request" => $request, "replacement" => $replacement, "view_declare" => $view_declare]);

    }

    public function resubmission(Request $request, $app_type, $card,$Status_App)
    {
        $request->merge(['app_type' => $app_type, 'card' => $card, 'Status_App' => $Status_App]);
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric])->first();
        return view('personal_particular')->with(['personal' => $personal, "request" => $request]);
    }

    public function backDraft(Request $request, $app_type, $card)
    {
        $request->merge(['app_type' => $app_type, 'card' => $card]);
        $this->ClearDataDraft($request);
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric])->first();
        return view('personal_particular')->with(['personal' => $personal, "request" => $request]);
    }

    public function savedraft(Request $request, $app_type, $card,$array_grade = false,$logout_save_draft = false)
    {
        $request->merge(['app_type' => $app_type, 'card' => $card]);
        $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->latest("created_at")->first();
        $sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->latest('created_at')->first();
//        if ($array_grade == false) {
//            if (!$booking_schedule->Status_app == resubmission) {
//                $save_draft = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
//                    ->update([
//                        'app_type' => $request->app_type,
//                        'Status_app' => draft,
//                        'declaration_date' => null,
//                        'Status_draft' => draft_book_appointment,
//                    ]);
//            }
//        }else{
//            if ($request->app_type == news){
////                die(print_r(json_decode($booking_schedule->array_grade)));
////                die(print_r(json_decode($array_grade)));
//                if (isset($array_grade) && isset($booking_schedule->array_grade)) {
//
//                    if (isset($array_grade) && isset($booking_schedule->array_grade) && count(json_decode($booking_schedule->array_grade)) <= count(json_decode($array_grade))) {
////                    die('+');
//                        $cek_false = array_search("false", json_decode($array_grade));
////                   die(print_r($cek_false));
//                        if ($cek_false == true) {
//                            $merge_array = json_decode($booking_schedule->array_grade);
//                        } else {
//                            $merge_array = json_decode($array_grade);
//                        }
//
//                    } else {
////                    die('-');
//                        $different_value = array_diff(array_map('trim', json_decode($booking_schedule->array_grade)), json_decode($array_grade));
//                        $merge_grade = json_decode($booking_schedule->array_grade);
//                        foreach ($different_value as $f) {
//                            if (($key = array_search($f, $merge_grade)) !== false) {
//                                unset($merge_grade[$key]);
//                            }
//                        }
//                        $merge_array = array_values($merge_grade);
//                    }
//                }else{
//                    $merge_array =null;
//                }
//
//            }elseif ($request->app_type == replacement || $request->app_type == renewal){
//                if (isset($sertifikat->array_grade) && isset($booking_schedule->array_grade) && isset($array_grade)) {
//                    $merge_array = $this->proses_grade(count(json_decode($sertifikat->array_grade)), json_decode($sertifikat->array_grade), json_decode($array_grade), json_decode($booking_schedule->array_grade), count(json_decode($booking_schedule->array_grade)), json_decode($booking_schedule->array_grade), json_decode($array_grade), true);
//                }else{
//                    $merge_array =null;
//                }
//            }
//            $check_false_grade = array_search("false", json_decode($array_grade));
////            die(print_r($check_false_grade));
//            if(!empty($check_false_grade) && $request->app_type == news){
//                $merge_array = null;
//            }elseif (!empty($check_false_grade) && $request->app_type == replacement || $request->app_type == renewal){
//                if (($key = array_search("false", $merge_array)) !== false) {
//                    unset($merge_array[$key]);
//                }
//            }
        if (substr(url()->previous(),-11) == cek_pathname_logout && $request->app_type ==so_app) {

            $TR_RTT = "";
            $TR_CSSPB = "";
            $TR_CCTC = "";
            $TR_HCTA = "";
            $TR_X_RAY = "";
            $TR_AVSO = "";
            foreach (json_decode($array_grade) as $f) {
                if ($f == "TR_RTT") {
                    $TR_RTT .= "YES";
                } else {
                    $TR_RTT .= null;
                }
                if ($f == "TR_CSSPB") {
                    $TR_CSSPB .= "YES";
                } else {
                    $TR_CSSPB .= null;
                }

                if ($f == "TR_CCTC") {
                    $TR_CCTC .= "YES";
                } else {
                    $TR_CCTC .= null;
                }

                if ($f == "TR_HCTA") {
                    $TR_HCTA .= "YES";
                } else {
                    $TR_HCTA .= null;
                }

                if ($f == "TR_X_RAY") {
                    $TR_X_RAY .= "YES";
                } else {
                    $TR_X_RAY .= null;
                }

                if ($f == "TR_AVSO") {
                    $TR_AVSO .= "YES";
                } else {
                    $TR_AVSO .= null;
                }

            }
        }
        if (!$booking_schedule->Status_app == resubmission){
            if (substr(url()->previous(),-11) == cek_pathname_logout  && $request->app_type ==so_app) {
                $save_draft = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                    ->update([
                        'app_type' => $request->app_type,
                        'declaration_date' => null,
                        'Status_app' => draft,
                        'Status_draft' => draft_book_appointment,
//                        'array_grade' => $merge_array,
                        'TR_RTT' => $TR_RTT,
                        'TR_CSSPB' => $TR_CSSPB,
                        'TR_CCTC' => $TR_CCTC,
                        'TR_HCTA' => $TR_HCTA,
                        'TR_X_RAY' => $TR_X_RAY,
                        'TR_AVSO' => $TR_AVSO,
                    ]);
            }else{
                $save_draft = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                    ->update([
                        'app_type' => $request->app_type,
                        'declaration_date' => null,
                        'Status_app' => draft,
                        'Status_draft' => draft_book_appointment,
//                        'array_grade' => $merge_array,
                    ]);
            }
        }
//        }
        if ($logout_save_draft == true){
            Artisan::call('cache:clear');
            Auth::logout();
            return redirect()->route('relogin');
        }else{
            return redirect()->route('landing_page');
        }
    }

    public function replacement_personaldata(Request $request)
    {
//        $request->merge(['app_type' => replacement, 'card' => $card]);
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric])->first();
        return view('personal_particular')->with(['personal' => $personal, "request" => $request]);
    }

    public function renewal_personaldata(Request $request)
    {
//        $request->merge(['app_type' => renewal, 'card' => $card]);
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric])->first();
        return view('personal_particular')->with(['personal' => $personal, "request" => $request]);
    }

    public function after_payment(Request $request,$card)
    {
//        die(print_r($request->all()));
        $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$card])->first();
        $t_grade = t_grade::get();
        $request->merge(['app_type' => $request->session()->all()['app_type'],'Status_app'=>$course->Status_app, 'thank_payment' => true,'card' => $card,'router_name' => Route::getCurrentRoute()->getActionName()]);

        return view('view_courses')->with(['t_grade' => $t_grade,'courses' => $course, "request" => $request]);
    }

    public function view_course(Request $request,$card)
    {
        $request->merge(['app_type' => renewal,'thank_payment' => false, 'card' => $card,'router_name' => Route::getCurrentRoute()->getActionName()]);
        $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$card])->first();
        $t_grade = t_grade::get();
        return view('view_courses')->with(['t_grade' => $t_grade,'courses' => $course, "request" => $request]);
    }
    public function save_barcode_paynow(Request $request)
    {
        $data_barcode = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card_id])
            ->update([
                'data_barcode_paynow' => $request->data_barcode,
            ]);
        return $data_barcode;

    }
    public function print_pdf(Request $request,$card)
    {
        $request->merge(['card' => $card]);
        $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$card])->first();
        $t_grade = t_grade::get();

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','enable_javascript' => true,'javascript-delay' => 5000]);
        $pdf = PDF::loadView('pdf_invoice', ['t_grade' => $t_grade,'courses' => $course, "request" => $request])->setPaper('a3','landscape');
//        return $pdf->stream();
        $content = $pdf->download()->getOriginalContent();
        $name_file = 'T_'.$course->passid.'_'.$course->receiptNo.'.pdf';
        Storage::put('public/invoice/'.$name_file,$content) ;

        return $pdf->download('App_Slip.pdf');
    }

    public function submission(Request $request)
    {
        $grade = null;
        $replacement = null;
        $view_declare = null;
        $cek_grade = null;
        $data_resubmission = null;
        $diff_data = $this->diff_data($request);
        if (!empty(json_decode($request->array_grade))){
            $join_grade = array_merge(json_decode($request->array_grade),$request->Cgrade);
            $request->merge(['Cgrade' => $join_grade]);
        }else{
            $request->merge(['Cgrade' => $request->Cgrade,'array_grade' => $request->Cgrade]);

        }
        if ($diff_data) {
            // Update
            $this->UpdateUsers($diff_data);
        }
        // view_declare
        if (!empty($request->Cgrade)) {
            if ($request->app_type == replacement) {
                $replacement = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
//                $array_grade = array_merge(json_decode($replacement->array_grade), $request->Cgrade);
                $view_declare = $request->Cgrade;
            } else {
                $view_declare = $request->Cgrade;
            }
        }
        // End view_declare
        $resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card, 'Status_app' => resubmission])->first();
        if (empty($resubmission)) {
            booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                ->update([
                    'declaration_date' => null,
                    'Status_app' => null,
                ]);
        }
        if ($request->card == so_app) {
            if ($request->app_type == renewal) {
                if (!empty($resubmission)) {
                    $data_resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                    $grade = grade::get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                } else {
                    $renewal = booking_schedule::where(['nric' => Auth::user()->nric])->leftjoin('grades', 'booking_schedules.grade_id', '=', 'grades.id')->first();
                    $grade = grade::where(['card_id' => $renewal->card_id])->get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                }
            } elseif ($request->app_type == replacement) {
                if (!empty($resubmission)) {
                    $data_resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                    $grade = grade::get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                } else {
                    $replacement = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
//                  $replacement = booking_schedule::first();
                    $grade = grade::where(['card_id' => $replacement->card_id])->get();
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                }
            } else {
                if (!empty($request->Cgrade)) {
                    // view declare more than 1
                    $grade = grade::get();
                    // end view declare more than 1
                    $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();

                } else {
                    if (!empty($resubmission)) {
                        $data_resubmission = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                        $grade = grade::get();
                        $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                    } else {
                        // user cannot belong to declare
                        $grade = grade::get();
                        $cek_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->first();
                        // End user cannot belong to declare
                    }
                }
            }
        } else {
            if ($request->app_type == replacement || $request->app_type == renewal) {
                $replacement = booking_schedule::where(['nric' => Auth::user()->nric])->first();
//                $request->merge(['card' => $replacement->card_id]);
            }
        }

//        // take grade (new design)
//        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
//        $take_grade_sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->latest('created_at')->first();
//        if (isset($take_grade) && isset($take_grade_sertifikat) && count(json_decode($take_grade->array_grade)) != count(json_decode($take_grade_sertifikat->array_grade))){
//            $grade_not_payment = array_diff(json_decode($take_grade->array_grade), json_decode($take_grade_sertifikat->array_grade));
//        }elseif (!empty($take_grade) && $take_grade->status_payment !=paid){
//            $grade_not_payment = json_decode($take_grade->array_grade);
//        }
//        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
//        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
//        if (!empty($take_grade)) {
//            foreach ($take_grades as $index => $f) {
//                if (!empty(json_decode($take_grade->array_grade))){
//                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
//                        if ($f->id == $g) {
//                            $take_grades[$index]->take_grade = true;
//                        }
//                    }
//                }
//
//                if (!empty($grade_not_payment)){
//                    foreach ($grade_not_payment as $index2 => $i) {
//                        if ($f->id == $i) {
//                            $take_grades[$index]->grade_not_payment = true;
//                            $take_grades[$index]->take_grade = false;
//                        }
//                    }
//                }
//
//            }
//        }
//        // end take grade (new design)

        // so and avso join
        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $take_grade_sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->latest('created_at')->first();
        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();

        if (!empty($take_grade)) {
            foreach ($take_grades as $index => $f) {
                // booking schedule
                if ($f->short_value =="TR_RTT" && isset($take_grade) && $take_grade->TR_RTT == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_CSSPB" && isset($take_grade) && $take_grade->TR_CSSPB == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_CCTC" &&  isset($take_grade) &&$take_grade->TR_CCTC == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_HCTA" && isset($take_grade) && $take_grade->TR_HCTA == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_X_RAY" && isset($take_grade) && $take_grade->TR_X_RAY == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                if ($f->short_value =="TR_AVSO" && isset($take_grade) && $take_grade->TR_AVSO == "YES"){
                    $take_grades[$index]->not_payment = true;
                }
                // end booking schedule

                // sertifikat
                if ($f->short_value =="TR_RTT" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_RTT == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_CSSPB" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_CSSPB == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_CCTC" &&  isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_CCTC == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_HCTA" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_HCTA == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_X_RAY" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_X_RAY == "YES"){
                    $take_grades[$index]->payment = true;
                }
                if ($f->short_value =="TR_AVSO" && isset($take_grade_sertifikat) && $take_grade_sertifikat->TR_AVSO == "YES"){
                    $take_grades[$index]->payment = true;
                }
                // end sertifikat

            }
        }
        // end so and avso join
//        die(print_r($take_grades));
        $personal = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['users.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$request->card])->first();
        $t_grade = t_grade::get();
        return view('submission')->with(['take_grades' => $take_grades,'t_grade' => $t_grade,'data_resubmission' => $data_resubmission, 'resubmission' => $resubmission, 'cek_grade' => $cek_grade, 'personal' => $personal, "grade" => $grade, "request" => $request, "replacement" => $replacement, "view_declare" => $view_declare,"take_sertifikat" => $take_grade_sertifikat]);
    }

    public function declare_submission(Request $request)
    {
        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
        $grade = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
        if (!empty(json_decode($request->array_grade))){
            $take_grade = array('array_grade'=>$request->array_grade);
            $take_grade = (object) $take_grade;
        }

        if (!empty($take_grade)) {
            foreach ($grade as $index => $f) {
                if (!empty(json_decode($request->array_grade))) {
                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
                        if ($f->id == $g) {
                            $grade[$index]->take_grade = true;
                        }
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

        return view('declare_submission')->with(["grade" => $grade, "request" => $request]);

    }

    public function cancel_payment(Request $request,$app_type,$card){
        $request->merge(['app_type' => $app_type, 'card' => $card]);
        $this->ClearDataDraft($request);
        return redirect()->route('landing_page');
    }
    public function book_appointment(Request $request)
    {
        $json_cgrades = json_encode($request->Cgrades);
        $Cgrades = urlencode($json_cgrades);
        $request->merge(['SentCgrades' =>$Cgrades]);
        $grade = false;
        if (!empty($request->grade)){
            $grade = $request->grade;
        }
        $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->first();
        $request->merge(['booking_schedule'=>$booking_schedule]);

        if (!empty($booking_schedule) && $booking_schedule->Status_app == resubmission){
            $request->merge(['Status_app' =>resubmission,'booking_schedule'=>$booking_schedule]);
            $diff_date_resubmission = date_diff(date_create(date('Y-m-d')),date_create($booking_schedule->appointment_date));
            $data_date = $diff_date_resubmission->format("%R%a");
            if ($data_date <= less_than_days){
                 booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])
                    ->update([
                        'appointment_date' => null,
                        'time_start_appointment' => null,
                        'time_end_appointment' => null,
                    ]);
            }

            $this->Saveresubmission($request,$grade);
//            return redirect('/home');
        }elseif (empty($booking_schedule)){
//            $this->NewBookingSchedule($request,$grade);
        }else{
            if (empty($booking_schedule->declaration_date)){
                $this->UpdateBookingSchedule($request,$grade);
            }

        }
        $dayHoliday = Dateholiday::get();
        return view('book_appointment')->with(["request"=>$request,"dayHoliday"=>$dayHoliday]);
    }
    public function HistoryBookAppointment(Request $request,$app_type,$card)
    {
        $request->merge(['app_type' => $app_type,'card' => $card]);

        $dayHoliday = Dateholiday::get();

        return view('book_appointment')->with(["request"=>$request,"dayHoliday"=>$dayHoliday]);
    }

    public function View_payment(Request $request)
    {
        $this->UpdateBookingScheduleAppointment($request);
        $booking_schedule = booking_schedule::leftjoin('users', 'booking_schedules.nric', '=', 'users.nric')->where(['booking_schedules.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$request->card])->first();
        $request->merge(['app_type' => $booking_schedule->app_type]);
        if ($booking_schedule->grade_id == null){
                  $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_type'=>$booking_schedule->grade_id])->first();
//                foreach (json_decode($booking_schedule->grade_id) as $f){
//                    $transaction_amount= transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id,'grade_id'=>$f])->first();
//                    $Array_transaction_amount[] = $transaction_amount->transaction_amount;
//                }
//                    $addition_transaction_amount = array_sum($Array_transaction_amount);
        }else{
            $transaction_amount = transaction_amount::where(['app_type'=>$booking_schedule->app_type,'card_type'=>$booking_schedule->card_id])->first();
        }


        $gst = gst::orderBy('id', 'desc')->first();
        $t_grade = t_grade::get();
        if ($request->valid_resubmission == true){
            $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])
                ->update([
                    'Status_app' => Resubmitted,
                    'resubmission_date' => date('d/m/Y H:i:s'),
                ]);
            return redirect('/home');
        }
        // Update Session
        $value_gst = ($gst->amount_gst/100)*$transaction_amount->transaction_amount;

        $grand_total = $transaction_amount->transaction_amount + $value_gst;

        session([
            'nric' => Auth::user()->nric,
            'app_type' => $booking_schedule->app_type,
            'card' => $request->card,
            'grand_total' => $grand_total,
            'grade_id' => $gst->id,
            'transaction_amount' => $transaction_amount->id
        ]);
        // End Update Session

        return view('payment_detail')->with(["t_grade"=>$t_grade,"gst"=>$gst,"booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount,'request'=>$request]);
    }

    public function HistoryViewPayment(Request $request,$app_type,$card)
    {
        $request->merge(['app_type' => $app_type,'card' => $card]);

//        $this->UpdateBookingScheduleAppointment($request);
        $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$card])->first();
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
        $t_grade = t_grade::get();
        return view('payment_detail')->with(["t_grade"=>$t_grade,"gst"=>$gst,"booking_schedule"=>$booking_schedule,'transaction_amount'=>$transaction_amount,'addition_transaction_amount'=>$addition_transaction_amount,'request'=>$request]);
    }

    public function Createpayment(Request $request)
    {
        $payment_method = $this->payment_method($request);

        if ($payment_method){
            $this->NewPayment($request->all(),$request);
        }

        $schedule = booking_schedule::where(['nric' => Auth::user()->nric])->first();
        return redirect()->route('landing_page');
//        return Redirect::route('after.payment', $request->card);
    }
    protected  function ClearDataDraft($request){
        $clear_data="";
        if ($request->app_type == news){
//            $clear_data = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->delete();
            $clear_data = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                ->update([
                    'Status_app' => draft,
                    'Status_draft' => draft_book_appointment,
                    'trans_date' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'receiptNo' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
                ]);
        }elseif ($request->app_type == replacement || $request->app_type == renewal) {
            $setifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->latest()->first();
            if (!empty($setifikat)){
                $clear_data = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                    ->update([
                        'Status_app' => draft,
                        'Status_draft' => draft_book_appointment,
//                        'app_type' => $setifikat->app_type,
//                        'array_grade' => $setifikat->array_grade,
//                    'declaration_date' => Carbon::parse($setifikat->declaration_date)->toDateString(),
                        'declaration_date' => $setifikat->declaration_date,
                        'trans_date' => $setifikat->trans_date,
                        'expired_date' => $setifikat->expired_date,
                        'paymentby' => $setifikat->paymentby,
                        'status_payment' => $setifikat->status_payment,
                        'receiptNo' => $setifikat->receiptNo,
//                        'Status_app' => $setifikat->Status_app,
                        'appointment_date' => $setifikat->appointment_date,
                        'time_start_appointment' => $setifikat->time_start_appointment,
                        'time_end_appointment' => $setifikat->time_end_appointment,
                    ]);
            }

        }
        return $clear_data;
    }

    protected  function  NewPayment($request,$requests){
        if ($request['payment_method'] == paynow){
            $payment_method = 'paynow';
        }elseif ($request['payment_method'] == enets){
            $payment_method = 'enets';
        }elseif ($request['payment_method'] == visa){
            $payment_method = 'visa';
        }elseif ($request['payment_method'] == mastercard){
            $payment_method = 'mastercard';
        }
        $BookingScheduleAppointment = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request['card']])
            ->update([
                'gst_id' => $request['grade_id'],
                'trans_date' => date('d/m/Y H:i:s'),
//                'expired_date' => date('Y-m-d', strtotime('+1 years')),
                'paymentby' => $payment_method,
                'status_payment' => paid,
                'grand_total' => $request['grand_total'],
//                'receiptNo' => $this->receiptNo(),
                'status_app' => processing,
                'transaction_amount_id' => $request['transaction_amount_id'],
            ]);
        $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' =>  Auth::user()->nric,'booking_schedules.card_id'=>$request['card']])->first();
        $t_grade = t_grade::get();
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','enable_javascript' => true,'javascript-delay' => 5000]);
        $pdf = PDF::loadView('pdf_invoice', ['t_grade' => $t_grade,'courses' => $course, "request" => $requests])->setPaper('a3','landscape');
//        return $pdf->stream();
        $content = $pdf->download()->getOriginalContent();
        $name_file = 'T_'.$course->passid.'_'.$course->receiptNo.'.pdf';
//        Storage::put('public/img/img_users/invoice/'.$name_file,$content) ;
        file_put_contents(public_path('img/img_users/invoice/'.$name_file), $content);

//            $receiptNo = new tbl_receiptNo;
//
//            $receiptNo->receiptNo = $this->receiptNo();
//
//            $receiptNo->save();
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
//        $sertifikat = sertifikat::whereDate('trans_date', '=', Carbon::today()->toDateTimeString())->count();
//        $booking_schedule = booking_schedule::whereNotIn('Status_app', [completed])->whereDate('trans_date', '=', Carbon::today()->toDateTimeString())->count();
//        $data = $sertifikat + $booking_schedule;
        $data = tbl_receiptNo::whereYear('created_at', Carbon::today()->format('Y'))->count();
        if ($data > 0){
            $booking_schedule =$data+1;
            $data_substr = strlen((string)$booking_schedule);
            $nnnn = substr(nnnn, $data_substr);
            $booking_schedule = $nnnn.''.$booking_schedule;
        }else{
            $booking_schedule = "00001";
        }
        $data = Carbon::today()->format('Ymd').''.$booking_schedule;
//        $data = "".Carbon::today()->format('d')."/".Carbon::today()->format('m')."/".Carbon::today()->format('y')."/".$booking_schedule;
        return $data;
    }
    protected function create_setifikat($request)
    {
        $data = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request['card']])->first();

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

        $sertifikat->nric            = $data->nric;

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
        $BookingScheduleAppointment = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])
                                        ->update([
                                            'appointment_date' => $date,
                                            'time_start_appointment' => $data->start_at,
                                            'time_end_appointment' => $data->end_at,
//                                            'Status_app' => draft,
                                            'receiptNo' => $this->receiptNo(),
                                            'Status_draft' => draft_payment,
                                        ]);
        $receiptNo = new tbl_receiptNo;

        $receiptNo->receiptNo = $this->receiptNo();

        $receiptNo->save();

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
        $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->first();
        $sertifikat = sertifikat::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->latest('created_at')->first();

//        if ($request->card == so_app){
//            $take_grade = $request->Cgrades;
//            if ($request->app_type == news){
//                foreach ($take_grade as $f ){
//                    $result=array_search("on",$take_grade);
//                        unset($take_grade[$result]);
//                }
//
//            }elseif($request->app_type == replacement || $request->app_type == renewal){
//                if (is_null($booking_schedule->Status_app) && $booking_schedule->Status_app == draft) {
//                        if (!empty(json_decode($request->Cgrade[0])) && count((json_decode($request->Cgrade[0]))) <=  count($request->Cgrades) && !count((json_decode($request->Cgrade[0]))) ==  count($request->Cgrades)) {
//                        foreach ($take_grade as $f) {
//                            $result = array_search("on", $take_grade);
//                            unset($take_grade[$result]);
//                        }
//                    }
//                }
//            }
//
//            if (!empty($booking_schedule->array_grade)){
//                $get_grade = json_decode($booking_schedule->array_grade);
//                $sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->latest('created_at')->first();
//                if (!empty($request->Cgrades)) {
//                    if (count(json_decode($request->Cgrade[0])) == count($request->Cgrades)){
//                        if ($request->app_type == news) {
//                            $merge_grade = array_merge($get_grade,$take_grade);
//                        }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                            $merge_grade = $this->proses_grade(count(json_decode($sertifikat->array_grade)),json_decode($sertifikat->array_grade),$request->Cgrades,json_decode($request->Cgrade[0]),count(json_decode($request->Cgrade[0])),$get_grade,$take_grade,false);
//                        }
//                    }else{
//                        if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)){
//                            if ($request->app_type == news) {
//                                if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                    $merge_grade = array_merge($get_grade,$take_grade);
//                                }else{
//                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                        foreach ($take_grade as $f) {
//                                            $result = array_search("on", $take_grade);
//                                            unset($take_grade[$result]);
//                                        }
//                                        $merge_grade = array_values(array_unique(array_merge($get_grade,$request->Cgrades)));
//                                    }else{
//                                        $take_grade = [$request->Cgrades[0]];
//                                        $merge_grade = array_merge($get_grade,$take_grade);
//                                    }
//
//                                }
//                            }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                                $merge_grade = $this->proses_grade(count(json_decode($sertifikat->array_grade)),json_decode($sertifikat->array_grade),$request->Cgrades,json_decode($request->Cgrade[0]),count(json_decode($request->Cgrade[0])),$get_grade,$take_grade,false);
//                            }
//                        }else{
//                            if ($request->app_type == news) {
//                                $different_value = array_diff(array_map('trim', json_decode($request->Cgrade[0])), $request->Cgrades);
//                                $merge_grade = json_decode($request->Cgrade[0]);
//                                foreach ($different_value as $f){
//                                    if (($key = array_search($f, $merge_grade)) !== false) {
//                                        unset($merge_grade[$key]);
//                                    }
//                                }
//                                $merge_grade = array_values($merge_grade);
//                            }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                                $merge_grade = $this->proses_grade(count(json_decode($sertifikat->array_grade)),json_decode($sertifikat->array_grade),$request->Cgrades,json_decode($request->Cgrade[0]),count(json_decode($request->Cgrade[0])),$get_grade,$take_grade,false);
//                            }
//                        }
//                    }
//                }else{
//                    $merge_grade = $get_grade;
//                }
//            }else{
//                $merge_grade = $request->Cgrades;
//            }
//        }
//        if($request->Cgrades[0] == "false" && $request->app_type == news){
//            $merge_grade = null;
//        }elseif ($request->Cgrades[0] == "false" && $request->app_type == replacement || $request->app_type == renewal){
//            if (($key = array_search("false", $merge_grade)) !== false) {
//                unset($merge_grade[$key]);
//            }
//        }
        $TR_RTT ="";
        $TR_CSSPB ="";
        $TR_CCTC ="";
        $TR_HCTA ="";
        $TR_X_RAY ="";
        $TR_AVSO ="";
        if ($request->card == so) {
            foreach ($request->Cgrades as $f) {
                if ($f == "TR_RTT") {
                    $TR_RTT .= "YES";
                } else {
                    $TR_RTT .= null;
                }
                if ($f == "TR_CSSPB") {
                    $TR_CSSPB .= "YES";
                } else {
                    $TR_CSSPB .= null;
                }

                if ($f == "TR_CCTC") {
                    $TR_CCTC .= "YES";
                } else {
                    $TR_CCTC .= null;
                }

                if ($f == "TR_HCTA") {
                    $TR_HCTA .= "YES";
                } else {
                    $TR_HCTA .= null;
                }

                if ($f == "TR_X_RAY") {
                    $TR_X_RAY .= "YES";
                } else {
                    $TR_X_RAY .= null;
                }

                if ($f == "TR_AVSO") {
                    $TR_AVSO .= "YES";
                } else {
                    $TR_AVSO .= null;
                }

            }
        }

        if ($request->app_type == renewal){
            $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
//                    'card_id' => $request->card,
//                    'grade_id' => $grade,
                    'bsoc' => $bsoc,
                    'ssoc' => $ssoc,
                    'sssc' => $sssc,
                    'array_grade' => $merge_grade,
                    'declaration_date' => Carbon::today()->format('d/m/Y'),
                    'Status_app' => draft,
                    'Status_draft' => draft_book_appointment,
                    'trans_date' => null,
//                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
//                    'passexpirydate' => $passexpirydate,
//                    'gst_id' => null,
//                    'transaction_amount_id' => null,
//                    'grand_total' => null,
                    'paymentby' => null,
                    'receiptNo' => null,
                    'status_payment' => null,
                    'nric' => Auth::user()->nric,
                    'TR_RTT' => $TR_RTT,
                    'TR_CSSPB' => $TR_CSSPB,
                    'TR_CCTC' => $TR_CCTC,
                    'TR_HCTA' => $TR_HCTA,
                    'TR_X_RAY' => $TR_X_RAY,
                    'TR_AVSO' => $TR_AVSO,
                ]);
        }elseif ($request->app_type == replacement){
            $booking_schedule = booking_schedule::where([ 'nric' => Auth::user()->nric,'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
//                    'card_id' => $request->card,
//                    'grade_id' => $grade,
                    'declaration_date' => Carbon::today()->format('d/m/Y'),
                    'Status_app' => null,
                    'Status_draft' => draft_book_appointment,
                    'array_grade' => $merge_grade,
                    'trans_date' => null,
//                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
//                    'passexpirydate' => $passexpirydate,
//                    'gst_id' => null,
//                    'transaction_amount_id' => null,
//                    'grand_total' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'receiptNo' => null,
                    'nric' => Auth::user()->nric,
                    'TR_RTT' => $TR_RTT,
                    'TR_CSSPB' => $TR_CSSPB,
                    'TR_CCTC' => $TR_CCTC,
                    'TR_HCTA' => $TR_HCTA,
                    'TR_X_RAY' => $TR_X_RAY,
                    'TR_AVSO' => $TR_AVSO,
                ]);
        }else{
            $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
                    'card_id' => $request->card,
//                    'grade_id' => $grade,
//                    'array_grade' => $request->Cgrade[0],
//                    'array_grade' => $merge_grade,
                    'declaration_date' => Carbon::today()->format('d/m/Y'),
//                    'status_app' => submission,
                    'trans_date' => null,
//                    'expired_date' => null,
                    'appointment_date' => null,
                    'time_start_appointment' => null,
                    'time_end_appointment' => null,
//                    'passexpirydate' => $passexpirydate,
                    'gst_id' => null,
                    'transaction_amount_id' => null,
                    'grand_total' => null,
                    'paymentby' => null,
                    'status_payment' => null,
                    'receiptNo' => null,
                    'nric' => Auth::user()->nric,
                    'TR_RTT' => $TR_RTT,
                    'TR_CSSPB' => $TR_CSSPB,
                    'TR_CCTC' => $TR_CCTC,
                    'TR_HCTA' => $TR_HCTA,
                    'TR_X_RAY' => $TR_X_RAY,
                    'TR_AVSO' => $TR_AVSO,
                ]);
        }

        return $booking_schedule;
    }

    protected  function proses_grade($Count_array_sertifikat,$array_sertifikat,$Cgrades,$array_booking,$Count_array_booking,$get_grade,$take_grade,$save_draft=false)
    {
        if ($Count_array_sertifikat == 1) {
            $sertifikat_merge = array_merge($array_sertifikat,$Cgrades);
            if (count($sertifikat_merge) >= $Count_array_booking){
//                                         die("+");
                $grade = $array_booking;
                unset($grade[0]);
                unset($grade[1]);
                if (count($array_booking) <= count($take_grade) && count($grade) != count($take_grade)) {
                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
                } else {
                    array_pop($get_grade);
                    array_pop($get_grade);
                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
                }
            }else{
//                                         die('-');
                $grade = $array_booking ;
                unset($grade[0]);
                if (count($grade) >= count($Cgrades)){
//                    die('1');
//                                    die(print_r($array_booking));
                    $different_value = array_diff(array_map('trim', $array_booking), $grade);
//                    die(print_r($different_value));

//                    die(print_r($Cgrades));
                    $merge_grade = array_values(array_unique(array_merge($different_value,$Cgrades)));
                }else {
//                    die('2');
                    $different_value = array_diff(array_map('trim', $grade), $Cgrades);
                    $merge_grade = $array_booking;
                    foreach ($different_value as $f) {
                        if (($key = array_search($f, $merge_grade)) !== false) {
                            unset($merge_grade[$key]);
                        }
                    }
                    $merge_grade = array_values($merge_grade);
                }
            }
        }elseif ($Count_array_sertifikat == 2) {
            $sertifikat_merge = array_merge($array_sertifikat,$Cgrades);
            if (count($sertifikat_merge) >= $Count_array_booking){
//                                         die("+");
                $grade = $array_booking;
                unset($grade[0]);
                unset($grade[1]);
                if (count($grade) == count($take_grade)) {
                    array_pop($get_grade);
                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
                } else {
                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
                }
            }else{
//             die('-');
                $grade = $array_booking ;
                unset($grade[0]);
                unset($grade[1]);
                $different_value = array_diff(array_map('trim', $grade), $Cgrades);
                $merge_grade = $array_booking;
                foreach ($different_value as $f){
                    if (($key = array_search($f, $merge_grade)) !== false) {
                        unset($merge_grade[$key]);
                    }
                }
                $merge_grade = array_values($merge_grade);
            }
        }elseif ($Count_array_sertifikat == 3) {
            $sertifikat_merge = array_merge($array_sertifikat,$Cgrades);
            if (count($sertifikat_merge) >= $Count_array_booking){
//                                         die("+");
                $grade = $array_booking;
                unset($grade[0]);
                unset($grade[1]);
                if (count($grade) == count($take_grade)) {
                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
                } else {
                    array_pop($get_grade);
                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
                }
            }else{
//                                         die('-');
                $grade = $array_booking ;
                unset($grade[0]);
                unset($grade[1]);
                unset($grade[2]);
                $different_value = array_diff(array_map('trim', $grade), $Cgrades);
                $merge_grade = $array_booking;
                foreach ($different_value as $f){
                    if (($key = array_search($f, $merge_grade)) !== false) {
                        unset($merge_grade[$key]);
                    }
                }
                $merge_grade = array_values($merge_grade);
            }
        }elseif ($Count_array_sertifikat == 4) {
            if ($Cgrades[0] == "false"){
                $sertifikat_merge = $array_sertifikat;
            }else{
                $sertifikat_merge = array_merge($array_sertifikat,$Cgrades);
            }
            if (count($sertifikat_merge) >= $Count_array_booking){
//                die('+');

                    $merge_grade = array_values(array_unique(array_merge($get_grade, $take_grade)));
            }else{
//              die('-');
                $grade = $array_booking ;
                unset($grade[0]);
                unset($grade[1]);
                unset($grade[2]);
                unset($grade[3]);
                $different_value = array_diff(array_map('trim', $grade), $Cgrades);
                $merge_grade = $array_booking;
                foreach ($different_value as $f){
                    if (($key = array_search($f, $merge_grade)) !== false) {
                        unset($merge_grade[$key]);
                    }
                }
                $merge_grade = array_values($merge_grade);
            }
        }
        return $merge_grade;
    }
    protected  function take_grade($array_grades)
    {
        // BSOC, SSOC, SSSC
        $Cgrade = json_decode($array_grades);
        $get_grade = grade::whereNull('delete_soft')->get();
        if (!empty($Cgrade)){
            foreach ($get_grade as $index => $f) {
                foreach ($Cgrade as $g) {
                    if ($f->id == $g){
                        $get_grade[$index]->Cgrade = true ;
                    }
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
        if (!empty($request->upload_profile)) {

            $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])->first();

            $imageName =$booking_schedule->passid . '' . substr(Auth::user()->nric, -4) . '.' . $request->upload_profile->getClientOriginalExtension();

            $request->upload_profile->move(public_path('img/img_users'), $imageName);

            $UpdateUser = User::find(Auth::id());

            $UpdateUser->photo = $imageName;

            $UpdateUser->save();

            return $UpdateUser;
        }
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

        $booking_schedule->Status_app = draft;

        $booking_schedule->passid = "123";

        $booking_schedule->Status_draft = draft_book_appointment;

        $booking_schedule->nric = Auth::user()->nric;

        $booking_schedule->save();

        return $booking_schedule;
    }

    protected function UpdateUsers($request){
        if(isset($request['email']) && isset($request['mobileno']) && isset($request['wpexpirydate']) && !empty($request['email']) && !empty($request['mobileno'] && !empty($request['wpexpirydate']))){
//            if(isset($request['email']) && isset($request['mobileno']) && isset($request['wpexpirydate']) && !empty($request['email']) && !empty($request['mobileno'] && !empty($request['wpexpirydate']))){
        $UpdateUser = User::find(Auth::id());

//        $UpdateUser->homeno = $request['homeno'];

        $UpdateUser->email = $request['email'];

//        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->wpexpirydate = $request['wpexpirydate'];

        $UpdateUser->save();
    }elseif(isset($request['email']) && isset($request['mobileno'])  && !empty($request['email']) && !empty($request['mobileno'] )){
//        }elseif(isset($request['email']) && isset($request['mobileno'])  && !empty($request['email']) && !empty($request['mobileno'] )){
        $UpdateUser = User::find(Auth::id());

//        $UpdateUser->homeno = $request['homeno'];

        $UpdateUser->email = $request['email'];

//        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->save();
    }elseif(!empty($request['email'])) {
//    }elseif(!empty($request['homeno'])) {
         $UpdateUser = User::find(Auth::id());

//        $UpdateUser->homeno = $request['homeno'];

         $UpdateUser->email = $request['email'];

         $UpdateUser->save();
     }elseif (!empty($request['mobileno'])){

         $UpdateUser = User::find(Auth::id());

//         $UpdateUser->mobileno = $request['mobileno'];
         $UpdateUser->mobileno = $request['mobileno'];

         $UpdateUser->save();
     }elseif (!empty($request['wpexpirydate'])){
        $UpdateUser = User::find(Auth::id());

        $UpdateUser->wpexpirydate = $request['wpexpirydate'];

        $UpdateUser->save();
    }
        return $UpdateUser;
    }
    protected function diff_data($request)
    {

        $agent = new Agent();
//        if ($agent->isDesktop() == true) {
//            if ($request->mobileno[0] != "6" || $request->mobileno[1] != "5") {
//                $mobileno = "65".$request->mobileno;
//            }else{
//                $mobileno = $request->mobileno;
//            }
//            $originData = array(
////                "homeno" => $request->homeno,
//                "email" => $request->email,
//                "wpexpirydate" => $request->wpexpirydate,
//                "mobileno" => $mobileno
//            );
//        }else{
//            if ($request->Phonemobileno[0] != "6" || $request->Phonemobileno[1] != "5") {
//                $Phonemobileno = "65".$request->Phonemobileno;
//            }else{
//                $Phonemobileno = $request->mobileno;
//            }
//            $originData = array(
////                "homeno" => $request->Phonehomeno,
//                "email" => $request->Phoneemail,
//                "wpexpirydate" => $request->Phonewpexpirydate,
//                "mobileno" => $Phonemobileno
//            );
//        }
        if ($agent->isDesktop() == true) {
            if ($request->view_mobileno[0] != "6" || $request->view_mobileno[1] != "5") {
                $mobileno = "65".$request->view_mobileno;
            }else{
                $mobileno = $request->view_mobileno;
            }
            $originData = array(
//                "homeno" => $request->homeno,
                "email" => $request->email,
                "wpexpirydate" => $request->wpexpirydate,
                "mobileno" => $mobileno
            );
        }else{
            if ($request->Phoneview_mobileno[0] != "6" || $request->Phoneview_mobileno[1] != "5") {
                $Phonemobileno = "65".$request->Phoneview_mobileno;
            }else{
                $Phonemobileno = $request->Phoneview_mobileno;
            }
            $originData = array(
//                "homeno" => $request->Phonehomeno,
                "email" => $request->Phoneemail,
                "wpexpirydate" => $request->Phonewpexpirydate,
                "mobileno" => $Phonemobileno
            );
        }
        $personal = User::where(['id'=>Auth::id()])->first();

        $result=array_diff($originData,$personal->toArray());

        return $result;
    }

    public function ui_update_so(Request $request)
    {
        $request->merge(['app_type' => "",'card' => ""]);
        $passID = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $data = so_update_info::where(['PassID' => $passID->passid])->first();
        return view('update_so')->with(['personal'=>$data,"request" => $request]);

    }
    public function action_update_so(Request $request)
    {
//        die(print_r($request->all()));
        if ($request->TR_RTT){
            $TR_RTT = "YES";
        }else{
            $TR_RTT = null;
        }
        if ($request->TR_CSSPB){
            $TR_CSSPB = "YES";
        }else{
            $TR_CSSPB = null;
        }
        if ($request->TR_CCTC){
            $TR_CCTC = "YES";
        }else{
            $TR_CCTC = null;
        }
        if ($request->TR_HCTA){
            $TR_HCTA = "YES";
        }else{
            $TR_HCTA = null;
        }
        if ($request->TR_X_RAY){
            $TR_X_RAY = "YES";
        }else{
            $TR_X_RAY = null;
        }
        if ($request->SKILL_BFM){
            $SKILL_BFM = "YES";
        }else{
            $SKILL_BFM = null;
        }
        if ($request->SKILL_BSS){
            $SKILL_BSS = "YES";
        }else{
            $SKILL_BSS = null;
        }
        if ($request->SKILL_FSM){
            $SKILL_FSM = "YES";
        }else{
            $SKILL_FSM = null;
        }
        if ($request->SKILL_CERT){
            $SKILL_CERT = "YES";
        }else{
            $SKILL_CERT = null;
        }
        if ($request->SKILL_COSEM){
            $SKILL_COSEM = "YES";
        }else{
            $SKILL_COSEM = null;
        }
        $update_grade = so_update_info::where(['PassID' => $request->PassID])
            ->update([
                'New_Grade' => $request->New_Grade,

                'TR_RTT' => $TR_RTT,

                'TR_CSSPB' => $TR_CSSPB,

                'TR_CCTC' => $TR_CCTC,

                'TR_HCTA' => $TR_HCTA,

                'TR_X_RAY' => $TR_X_RAY,

                'SKILL_BFM' => $SKILL_BFM,

                'SKILL_BSS' => $SKILL_BSS,

                'SKILL_FSM' => $SKILL_FSM,

                'SKILL_CERT' => $SKILL_CERT,

                'SKILL_COSEM' => $SKILL_COSEM,

                'Date_Submitted' => now(),

                'updated_at' => now(),
            ]);

        return redirect()->route('landing_page');
    }
}
