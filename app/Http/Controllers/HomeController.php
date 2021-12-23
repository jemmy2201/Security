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


//        die(print_r($replacement));

        $from_new_to_replacement = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>news,'Status_app'=>completed])
            ->orderBy('card_id', 'asc')->get();
        if (count($replacement) == zero){
            foreach ($from_new_to_replacement as $index => $f) {
                if (Carbon::today()->toDateString() < Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d')) {
                    $replacement = $from_new_to_replacement;
                    $replacement = array_merge($replacement->toArray(), $from_new_to_replacement->toArray());
                    $replacement = json_decode(json_encode($replacement), false);
                }
            }
        }


//        $before_renewal = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>replacement,'Status_app'=>completed])
//            ->orderBy('card_id', 'asc')->get();

//        $after_renewal = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>renewal,'Status_app'=>completed])
//            ->orderBy('card_id', 'asc')->get();

//        $result_renewal =  array_merge($before_renewal->toArray(), $after_renewal->toArray());
//        $renewal = json_decode(json_encode($result_renewal), FALSE);

        $renewals = booking_schedule::where(['nric' => Auth::user()->nric,'app_type'=>renewal])
            ->where('Status_app', completed)
//            ->whereNotIn('status_payment', [paid])
            ->orderBy('card_id', 'asc')->get();

        $renewal = array();
        foreach ($renewals as $index => $f) {
            if (Carbon::today()->toDateString() < Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d')) {
                if (count($replacement) == zero){
                    $replacement = array();
                }
                $replacement = array_merge($replacement, $renewals->toArray());
                $replacement = json_decode(json_encode($replacement), false);
            }else{
                $replacement = array();
            };
        }

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
                $renewal = array_merge($renewal, $next_new->toArray());
                $renewal = json_decode(json_encode($renewal), false);
            }
        }

        $grade = grade::get();
        if (Auth::user()->role == admin  ) {
            return view('admin/historylogin');
        }elseif(Auth::user()->role == office){
            return view('admin/upgrade_grade');
        }
//        die(print_r($sertifikat->first()));
        return view('landing_page')->with(["schedule" => $schedule, "sertifikat" => $sertifikat, "grade" => $grade,"new" => $new,
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

        // take grade (new design)
        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
        if (!empty($take_grade)) {
            foreach ($take_grades as $index => $f) {
                if (!empty(json_decode($take_grade->array_grade))){
                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
                        if ($f->id == $g) {
                            $take_grades[$index]->take_grade = true;
                        }
                    }
                }
            }
        }
        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $take_grade_sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->latest('created_at')->first();
        if (isset($take_grade) && isset($take_grade_sertifikat) && count(json_decode($take_grade->array_grade)) != count(json_decode($take_grade_sertifikat->array_grade))){
            $grade_not_payment = array_diff(json_decode($take_grade->array_grade), json_decode($take_grade_sertifikat->array_grade));
        }elseif (!empty($take_grade) && $take_grade->status_payment !=paid){
            $grade_not_payment = json_decode($take_grade->array_grade);
        }
        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
        if (!empty($take_grade)) {
            foreach ($take_grades as $index => $f) {
                if (!empty(json_decode($take_grade->array_grade))){
                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
                        if ($f->id == $g) {
                            $take_grades[$index]->take_grade = true;
                        }
                    }
                }

                if (!empty($grade_not_payment)){
                    foreach ($grade_not_payment as $index2 => $i) {
                        if ($f->id == $i) {
                            $take_grades[$index]->grade_not_payment = true;
                            $take_grades[$index]->take_grade = false;
                        }
                    }
                }

            }
        }
        // end take grade (new design)
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
        if ($array_grade == false) {
            if (!$booking_schedule->Status_app == resubmission) {
                $save_draft = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                    ->update([
                        'app_type' => $request->app_type,
                        'Status_app' => draft,
                        'declaration_date' => null,
                        'Status_draft' => draft_book_appointment,
                    ]);
            }
        }else{
            $temp_array_grade = json_decode($array_grade);
            $sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->latest()->first();
            if ($request->app_type == news) {
                if (is_null($booking_schedule->Status_app) && !$booking_schedule->Status_app == draft) {
                    foreach ($temp_array_grade as $f) {
                        $result = array_search("on", $temp_array_grade);
                        $remove_false = array_search("false", $temp_array_grade);
                        unset($temp_array_grade[$result]);
                        unset($temp_array_grade[$remove_false]);
//                        unset($temp_array_grade[$remove_zero]);
                    }
                }
            }elseif($request->app_type == replacement || $request->app_type == renewal){
                if (is_null($booking_schedule->Status_app) && $booking_schedule->Status_app == draft) {
//                    die('s');
                    if (isset($booking_schedule->array_grade) && count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
                            foreach ($temp_array_grade as $f) {
                                $result = array_search("on", $temp_array_grade);
                                $remove_false = array_search("false", $temp_array_grade);
                                unset($temp_array_grade[$result]);
                                unset($temp_array_grade[$remove_false]);
                            }
//                                    die(print_r($temp_array_grade));
                    }
                }
            }

//            die(print_r($temp_array_grade));
//            die(print_r($booking_schedule->array_grade));
            if (!empty($booking_schedule->array_grade)) {
//                die(print_r(count($temp_array_grade)));
//                die(print_r(count(json_decode($booking_schedule->array_grade))));
                if (count($temp_array_grade) == count(json_decode($booking_schedule->array_grade))) {
//                    die('2');
                    foreach ($temp_array_grade as $f) {
                        $result = array_search("on", $temp_array_grade);
                        $remove_false = array_search("false", $temp_array_grade);
                        unset($temp_array_grade[$result]);
                        unset($temp_array_grade[$remove_false]);
                    }
                    $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                }else{
                    if ( count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)){
//                        die('s');
                        if ( count(json_decode($booking_schedule->array_grade)) >=  count($temp_array_grade)) {
//                            die('1');
                            $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                        }else {
//                            die('2');
                            if ( count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
                                for ($i = 1; $i <= 4; $i++) {
                                    $result = array_search("on", $temp_array_grade);
                                    unset($temp_array_grade[$result]);
                                }
                                $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                            }else{
                                foreach ($temp_array_grade as $f) {
                                    $result = array_search("on", $temp_array_grade);
                                    $remove_false = array_search("false", $temp_array_grade);
                                    unset($temp_array_grade[$result]);
                                    unset($temp_array_grade[$remove_false]);
                                }
                                $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                            }

                        }
                    }else{
                        if ($request->app_type == news) {
                            $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);
//                        die(print_r($different_value));
//                        die(print_r(count($temp_array_grade)));
//                        die(print_r(count(json_decode($booking_schedule->array_grade))));
                            $merge_array = json_decode($booking_schedule->array_grade);
//                        die(print_r($merge_array));
                            for ($x = 1; $x <= $different_value; $x++) {
                                array_pop($merge_array);
                            }
                        }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                                                    die(print_r(count($temp_array_grade)));
//                        die(print_r(count(json_decode($booking_schedule->array_grade))));
                            if (count(json_decode($booking_schedule->array_grade)) >= count($temp_array_grade)){
                                if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
                                    $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                }else {
                                    if (count(json_decode($booking_schedule->array_grade)) >=  count($temp_array_grade)) {
//                                        die('1');
                                        if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                            die('1');
                                            $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                        }else{
//                                            die('2');
                                            if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                             die('1');
                                                $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                $merge_array = json_decode($booking_schedule->array_grade);
                                                for ($x = 1; $x <= $different_value; $x++) {
                                                    array_pop($merge_array);
                                                }
                                            }else{
//                                                die('2');
                                                if (count(json_decode($booking_schedule->array_grade)) >=  count($temp_array_grade)) {
//                                                    die('1');
                                                    if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                                        die('1');
                                                        $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                        $merge_array = json_decode($booking_schedule->array_grade);
                                                        for ($x = 1; $x <= $different_value; $x++) {
                                                            array_pop($merge_array);
                                                        }
                                                    }else{
//                                                        die('2');
                                                        if (count(json_decode($booking_schedule->array_grade)) >=  count($temp_array_grade)) {
//                                                            die('1');
                                                            if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                                                die('1');
                                                                $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                                $merge_array = json_decode($booking_schedule->array_grade);
                                                                for ($x = 1; $x <= $different_value; $x++) {
                                                                    array_pop($merge_array);
                                                                }
                                                            }else{
//                                                                die('2');
                                                                if (count(json_decode($booking_schedule->array_grade)) >=  count($temp_array_grade)) {
//                                                                    die('1');
                                                                    if (count(json_decode($booking_schedule->array_grade)) >=  count($temp_array_grade)) {
//                                                                        die('1');
                                                                        if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                                                            die('1');
                                                                            $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                                        }else{
//                                                                            die('2');
                                                                            if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                                                                die('1');
                                                                                $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                                                $merge_array = json_decode($booking_schedule->array_grade);
                                                                                for ($x = 1; $x <= $different_value; $x++) {
                                                                                    array_pop($merge_array);
                                                                                }
                                                                            }else{
//                                                                                die('2');
                                                                                if (count(json_decode($booking_schedule->array_grade)) <=  count($temp_array_grade)) {
//                                                                                    die('1');
                                                                                    $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                                                }else{
//                                                                                    die('2');
//                                                                                    die(print_r(count($temp_array_grade)));
                                                                                     if (count($temp_array_grade)== 4){
//                                                                                         die('1');
                                                                                         foreach ($temp_array_grade as $f) {
                                                                                             $result = array_search("on", $temp_array_grade);
                                                                                             $remove_false = array_search("false", $temp_array_grade);
                                                                                             unset($temp_array_grade[$result]);
                                                                                             unset($temp_array_grade[$remove_false]);
                                                                                         }
                                                                                         if (empty($temp_array_grade)){
                                                                                             $different_value = count(json_decode($booking_schedule->array_grade)) - 4;
//                                                                                        die(print_r($different_value));
                                                                                             $merge_array = json_decode($booking_schedule->array_grade);
                                                                                             for ($x = 1; $x <= $different_value; $x++) {
                                                                                                 array_pop($merge_array);
                                                                                             }
                                                                                         }else {
                                                                                             $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                                                             $merge_array = json_decode($booking_schedule->array_grade);
                                                                                             for ($x = 1; $x <= $different_value; $x++) {
                                                                                                 array_pop($merge_array);
                                                                                             }
                                                                                         }
                                                                                     }elseif (count($temp_array_grade)== 3){
//                                                                                         die('s');
                                                                                        foreach ($temp_array_grade as $f) {
                                                                                            $result = array_search("on", $temp_array_grade);
                                                                                            $remove_false = array_search("false", $temp_array_grade);
                                                                                            unset($temp_array_grade[$result]);
                                                                                            unset($temp_array_grade[$remove_false]);
                                                                                        }
                                                                                        if (empty($temp_array_grade)){
                                                                                            $different_value = count(json_decode($booking_schedule->array_grade)) - 3;
//                                                                                        die(print_r($different_value));
                                                                                            $merge_array = json_decode($booking_schedule->array_grade);
                                                                                            for ($x = 1; $x <= $different_value; $x++) {
                                                                                                array_pop($merge_array);
                                                                                            }
                                                                                        }else {
                                                                                            $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                                                            $merge_array = json_decode($booking_schedule->array_grade);
                                                                                            for ($x = 1; $x <= $different_value; $x++) {
                                                                                                array_pop($merge_array);
                                                                                            }
                                                                                        }
                                                                                    }elseif (count($temp_array_grade)== 2){
//                                                                                         die('s');
                                                                                         foreach ($temp_array_grade as $f) {
                                                                                             $result = array_search("on", $temp_array_grade);
                                                                                             $remove_false = array_search("false", $temp_array_grade);
                                                                                             unset($temp_array_grade[$result]);
                                                                                             unset($temp_array_grade[$remove_false]);
                                                                                         }
                                                                                         if (empty($temp_array_grade)){
                                                                                             $different_value = count(json_decode($booking_schedule->array_grade)) - 2;
//                                                                                        die(print_r($different_value));
                                                                                             $merge_array = json_decode($booking_schedule->array_grade);
                                                                                             for ($x = 1; $x <= $different_value; $x++) {
                                                                                                 array_pop($merge_array);
                                                                                             }
                                                                                         }else {
//                                                                                             die('s');
                                                                                             if (count(json_decode($booking_schedule->array_grade)) == 2 || count(json_decode($booking_schedule->array_grade)) == 3){
//                                                                                                 die('1');
                                                                                                 $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                                                             }else {
                                                                                                 $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                                                                 $merge_array = json_decode($booking_schedule->array_grade);
                                                                                                 for ($x = 1; $x <= $different_value; $x++) {
                                                                                                     array_pop($merge_array);
                                                                                                 }
                                                                                             }
                                                                                         }
                                                                                     }elseif (count($temp_array_grade)== 1){
//                                                                                         die('s');
                                                                                         foreach ($temp_array_grade as $f) {
                                                                                             $result = array_search("on", $temp_array_grade);
                                                                                             $remove_false = array_search("false", $temp_array_grade);
                                                                                             unset($temp_array_grade[$result]);
                                                                                             unset($temp_array_grade[$remove_false]);
                                                                                         }
                                                                                         if (empty($temp_array_grade)){
                                                                                             $different_value = count(json_decode($booking_schedule->array_grade)) - 1;
//                                                                                        die(print_r($different_value));
                                                                                             $merge_array = json_decode($booking_schedule->array_grade);
                                                                                             for ($x = 1; $x <= $different_value; $x++) {
                                                                                                 array_pop($merge_array);
                                                                                             }
                                                                                         }else {
//                                                                                             die(print_r(count(json_decode($booking_schedule->array_grade))));
                                                                                             if (count(json_decode($booking_schedule->array_grade)) == 2 || count(json_decode($booking_schedule->array_grade)) == 3 || count(json_decode($booking_schedule->array_grade)) == 4){
//                                                                                                 die('1');
                                                                                                 $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                                                             }else{
//                                                                                                 die('2');
                                                                                                 $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);
                                                                                                 $merge_array = json_decode($booking_schedule->array_grade);
                                                                                                 for ($x = 1; $x <= $different_value; $x++) {
                                                                                                     array_pop($merge_array);
                                                                                                 }
                                                                                             }

                                                                                         }
                                                                                     }else{
//                                                                                         die('2');
                                                                                         $merge_array = array_merge(json_decode($booking_schedule->array_grade));
                                                                                     }
                                                                                }
                                                                            }

                                                                        }
                                                                    }else{
//                                                                        die('2');
                                                                        $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                                                        $merge_array = json_decode($booking_schedule->array_grade);
                                                                        for ($x = 1; $x <= $different_value; $x++) {
                                                                            array_pop($merge_array);
                                                                        }
                                                                    }

                                                                }else{
//                                                                    die('2');
                                                                    $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                                }
                                                            }

                                                        }else{
//                                                            die('2');
                                                            $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                        }
                                                    }

                                                }else{
//                                                    die('2');
                                                    $merge_array = array_merge(json_decode($booking_schedule->array_grade), $temp_array_grade);
                                                }
                                            }

                                        }

                                    }else{
//                                        die('2');
                                        $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);

                                        $merge_array = json_decode($booking_schedule->array_grade);
                                        for ($x = 1; $x <= $different_value; $x++) {
                                            array_pop($merge_array);
                                        }
                                    }
//                                   die(print_r($merge_array));
                                }
                            }else{
//                                    die('2');
                                $different_value = count(json_decode($booking_schedule->array_grade)) - count($temp_array_grade);
//                                die(print_r($different_value));
                                $merge_array = json_decode($booking_schedule->array_grade);
//                                die(print_r($merge_array));

                                for ($x = 1; $x <= $different_value; $x++) {
                                    array_pop($merge_array);
                                }
                            }
                        }
                    }
                }
            }else{
                $merge_array = json_decode($array_grade);
            }

            if (empty($merge_array)){
                $merge_array = null;
            }else{
                $merge_array = json_encode($merge_array);
            }
//            die(print_r(json_encode($merge_array)));
            if (!$booking_schedule->Status_app == resubmission){
                $save_draft = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])
                    ->update([
                        'app_type' => $request->app_type,
                        'declaration_date' => null,
                        'Status_app' => draft,
                        'Status_draft' => draft_book_appointment,
                        'array_grade' => $merge_array,
                    ]);
            }
        }
        if ($logout_save_draft == true){
            Artisan::call('cache:clear');
            Auth::logout();
            return redirect()->route('home');
        }else{
            return redirect()->route('home');
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

    public function print_pdf(Request $request,$card)
    {
        $request->merge(['card' => $card]);
        $course = User::leftjoin('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
            ->where(['booking_schedules.nric' => Auth::user()->nric,'booking_schedules.card_id'=>$card])->first();
        $t_grade = t_grade::get();
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf_invoice', ['t_grade' => $t_grade,'courses' => $course, "request" => $request])->setPaper('a5','landscape');
//        return $pdf->stream();
        return $pdf->download('Receipt.pdf');
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

        // take grade (new design)
        $take_grade = booking_schedule::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->first();
        $take_grade_sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => so_app])->latest('created_at')->first();
        if (isset($take_grade) && isset($take_grade_sertifikat) && count(json_decode($take_grade->array_grade)) != count(json_decode($take_grade_sertifikat->array_grade))){
            $grade_not_payment = array_diff(json_decode($take_grade->array_grade), json_decode($take_grade_sertifikat->array_grade));
        }elseif (!empty($take_grade) && $take_grade->status_payment !=paid){
            $grade_not_payment = json_decode($take_grade->array_grade);
        }
        $selected_grade = booking_schedule::where(['card_id' => so_app, 'nric' => Auth::user()->nric])->first();
        $take_grades = grade::where(['card_id' => so_app])->whereNull('delete_soft')->orderBy('type', 'asc')->get();
        if (!empty($take_grade)) {
            foreach ($take_grades as $index => $f) {
                if (!empty(json_decode($take_grade->array_grade))){
                    foreach (json_decode($take_grade->array_grade) as $index2 => $g) {
                        if ($f->id == $g) {
                            $take_grades[$index]->take_grade = true;
                        }
                    }
                }

                if (!empty($grade_not_payment)){
                    foreach ($grade_not_payment as $index2 => $i) {
                        if ($f->id == $i) {
                            $take_grades[$index]->grade_not_payment = true;
                            $take_grades[$index]->take_grade = false;
                        }
                    }
                }

            }
        }
        // end take grade (new design)


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
        return redirect()->route('home');
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
            $this->NewPayment($request->all());
        }

        $schedule = booking_schedule::where(['nric' => Auth::user()->nric])->first();
//        return redirect()->route('home');
        return Redirect::route('after.payment', $request->card);
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

    protected  function  NewPayment($request){
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
                'status_app' => submitted,
                'transaction_amount_id' => $request['transaction_amount_id'],
            ]);

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

        if ($request->card == so_app){
            $take_grade = $request->Cgrades;
//            dd($take_grade);
            if ($request->app_type == news){
                foreach ($take_grade as $f ){
                    $result=array_search("on",$take_grade);
//                    if (!is_null($booking_schedule->Status_app) && $booking_schedule->Status_app == draft) {
                        //                dd($booking_schedule->Status_app);
                        unset($take_grade[$result]);
//                    }
                }

            }elseif($request->app_type == replacement || $request->app_type == renewal){
                if (is_null($booking_schedule->Status_app) && $booking_schedule->Status_app == draft) {
//                    die(print_r($take_grade));
//                    die(print_r($request->Cgrade[0]));
                        if (!empty(json_decode($request->Cgrade[0])) && count((json_decode($request->Cgrade[0]))) <=  count($request->Cgrades) && !count((json_decode($request->Cgrade[0]))) ==  count($request->Cgrades)) {
                        foreach ($take_grade as $f) {
                            $result = array_search("on", $take_grade);
                            unset($take_grade[$result]);
                        }
//                                    die(print_r($take_grade));
                    }
                }
            }

            // New function array grade

//            die(print_r($request->all()));
//            if (!empty($booking_schedule->array_grade)){
//                $result = array_search("on", $request->Cgrades);
//                die(print_r($result));
//            }else{
//                $merge_grade = $request->Cgrades;
//            }
            // End New function array grade


            if (!empty($booking_schedule->array_grade)){
                $get_grade = json_decode($booking_schedule->array_grade);
                $sertifikat = sertifikat::where(['nric' => Auth::user()->nric, 'card_id' => $request->card])->latest('created_at')->first();
                if (!empty($request->Cgrades)) {
//                        die(print_r(count(json_decode($request->Cgrade[0]))));
//                        die(print_r(count($request->Cgrades)));
//                        die(print_r($request->all()));

                    if (count(json_decode($request->Cgrade[0])) == count($request->Cgrades)){
//                        die('s');
                        if ($request->app_type == news) {
//                            die('s');
                            $merge_grade = array_merge($get_grade,$take_grade);
                        }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                            die('s');
                            if (count(json_decode($request->Cgrade[0])) == count($request->Cgrades)) {
//                                die('1');
                                if (count(json_decode($request->Cgrade[0])) == count($request->Cgrades)) {
//                                    die('1');
                                    if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
                                        if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                            die('1');
                                            if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                die('1');
                                                if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                    die('1');
                                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                        die('1');
                                                        $merge_grade = array_merge($get_grade,$take_grade);
                                                    }else{
//                                                        die('2');
                                                        foreach ($take_grade as $f) {
                                                            $result = array_search("on", $take_grade);
                                                            unset($take_grade[$result]);
                                                        }
                                                        $merge_grade = array_merge($get_grade,$take_grade);
                                                    }

                                                }else{
//                                                    die('2');
                                                    $merge_grade = array_merge($get_grade,$take_grade);
                                                }
                                            }else{
//                                                die('2');
                                                foreach ($take_grade as $f) {
                                                    $result = array_search("on", $take_grade);
                                                    unset($take_grade[$result]);
                                                }
                                                $merge_grade = array_merge($get_grade,$take_grade);
                                            }

                                        }else{
//                                            die('2');
                                            unset($take_grade[1]);
                                            $merge_grade = array_merge($get_grade,$take_grade);
                                        }
                                    }else{
//                                        die('2');
                                        foreach ($take_grade as $f) {
                                            $result = array_search("on", $take_grade);
                                            unset($take_grade[$result]);
                                        }
                                        $merge_grade = array_merge($get_grade,$take_grade);
                                    }

                                }else{
//                                    die('2');
                                    $merge_grade = array_merge($get_grade,$take_grade);
                                }
                            }else{
//                                die('2');
                                foreach ($take_grade as $f) {
                                    $result = array_search("on", $take_grade);
                                    unset($take_grade[$result]);
                                }
                                $merge_grade = array_merge($get_grade,$take_grade);
                            }

                        }
                    }else{
//                        die('ss');
                        if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)){
//                            die('s');
                            if ($request->app_type == news) {
                                if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
                                    $merge_grade = array_merge($get_grade,$take_grade);
                                }else{
                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
                                        foreach ($take_grade as $f) {
                                            $result = array_search("on", $take_grade);
                                            unset($take_grade[$result]);
                                        }
                                        $merge_grade = array_merge($get_grade,$take_grade);
                                    }else{
                                        $take_grade = [$request->Cgrades[0]];
                                        $merge_grade = array_merge($get_grade,$take_grade);
                                    }

                                }
                            }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                                die('2');
                                if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                    die('1');
                                    foreach ($take_grade as $f) {
                                        $result = array_search("on", $take_grade);
                                        unset($take_grade[$result]);
                                    }
                                    $merge_grade = array_merge($get_grade,$take_grade);

                                }else{
//                                        die('2');
                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                        die('1');
                                        if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                            die('1');
                                            foreach ($take_grade as $f) {
                                                $result = array_search("on", $take_grade);
                                                unset($take_grade[$result]);
                                            }
                                            $merge_grade = array_merge($get_grade,$take_grade);
                                        }else{
//                                            die('2');
                                            if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                die('1');
                                                if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                    die('1');
                                                    if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                        die('1');
                                                        foreach ($take_grade as $f) {
                                                            $result = array_search("on", $take_grade);
                                                            unset($take_grade[$result]);
                                                        }
                                                        $merge_grade = array_merge($get_grade,$take_grade);
                                                    }else{
//                                                        die('2');
                                                        $merge_grade = array_merge($get_grade,$take_grade);
                                                    }
                                                }else{
//                                                    die('2');
                                                    $merge_grade = array_merge($get_grade,$take_grade);
                                                }
                                            }else{
//                                                die('2');
                                                unset($take_grade[1]);
                                                $merge_grade = array_merge($get_grade,$take_grade);
                                            }
                                        }

                                    }else{
//                                        die('2');
                                        $merge_grade = array_merge($get_grade,$take_grade);
                                    }
                                }
                            }
                        }else{
//                            die('s');
                            if ($request->app_type == news) {
                                $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
//                                die(print_r(count($request->Cgrades)));
                                $merge_grade = array_merge($get_grade,$take_grade);
                                for ($x = 1; $x <= $different_value; $x++) {
                                    array_pop($merge_grade);
                                }
                            }elseif ($request->app_type == replacement || $request->app_type == renewal) {
//                                die('s');
                                if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)){
//                                    die('1');
                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                        die('1');
                                        $merge_grade = array_merge($take_grade, $get_grade);
                                    }else{
//                                        die('2');
                                        if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                            die('1');
                                            if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)){
//                                                die('1');
                                                foreach ($take_grade as $f) {
                                                    $result = array_search("on", $take_grade);
                                                    unset($take_grade[$result]);
                                                }
                                                $merge_grade = array_merge($get_grade,$take_grade);
                                            }else{
//                                            die('2');
                                                if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                    die('1');
//                                                    die(print_r($request->all()));
//                                                    die(print_r($take_grade));
                                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                        die('1');
                                                        foreach ($take_grade as $f) {
                                                            $result = array_search("on", $take_grade);
                                                            unset($take_grade[$result]);
                                                        }
                                                        $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
//                                                    $merge_grade = array_merge($get_grade,$take_grade);
                                                        $merge_grade = array_merge($get_grade, $take_grade);
                                                        for ($x = 1; $x <= $different_value; $x++) {
                                                            array_pop($merge_grade);
                                                        }
                                                    }else{
//                                                        die('2');
                                                        if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                            die('1');
                                                            if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                                die('1');
                                                                if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                                    die('1');
                                                                    $different_values = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                    if ($different_values == 3){
//                                                                        die('1');
                                                                        $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                    }else{
//                                                                        die('2');
                                                                        $different_value = $different_values + count(json_decode($sertifikat->array_grade));
                                                                    }
                                                                    $merge_grade = array_merge($get_grade,$take_grade);
                                                                    for ($x = 1; $x <= $different_value; $x++) {
                                                                        array_pop($merge_grade);
                                                                    }
                                                                }else{
//                                                                    die('2');
                                                                    if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                                        die('1');
                                                                        if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                                            die('1');
                                                                            $different_values = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                            $different_value = "";
                                                                            if ($different_values == 4){
                                                                                $different_value == 1;
                                                                            }else{
                                                                                $different_value == $different_values;
                                                                            }
                                                                            foreach ($take_grade as $f) {
                                                                                $result = array_search("on", $take_grade);
                                                                                unset($take_grade[$result]);
                                                                            }
                                                                            $merge_grade = array_merge($get_grade,$take_grade);
                                                                            array_pop($merge_grade);
                                                                        }else{
//                                                                            die('2');
                                                                            if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                                                die('1');
                                                                                if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                                                    die('1');
                                                                                    $different_value = '';
                                                                                    $different_values = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                                    if ($different_values == 4){
                                                                                        $different_value == 1;
                                                                                    }else{
                                                                                        $different_value == $different_values;
                                                                                    }
                                                                                    foreach ($take_grade as $f) {
                                                                                        $result = array_search("on", $take_grade);
                                                                                        unset($take_grade[$result]);
                                                                                    }
                                                                                    $merge_grade = array_merge($get_grade,$take_grade);
                                                                                    array_pop($merge_grade);
                                                                                }else{
//                                                                                    die('2');
                                                                                    if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                                                        die('1');
                                                                                        if(count($take_grade) == 1){
                                                                                            foreach ($take_grade as $f) {
                                                                                                $result = array_search("on", $take_grade);
                                                                                                unset($take_grade[$result]);
                                                                                            }
                                                                                            $merge_grade = array_merge($get_grade, $take_grade);
                                                                                            array_pop($merge_grade);

                                                                                        }else {
                                                                                            $merge_grade = array_merge($get_grade, $take_grade);
                                                                                        }

                                                                                    }else{
//                                                                                        die('2');
                                                                                        if (count(json_decode($request->Cgrade[0])) <= count($request->Cgrades)) {
//                                                                                            die('1');
                                                                                            $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                                            if ($different_value == 2){
//                                                                                            die('1');
                                                                                                $merge_grade = array_merge($get_grade,$take_grade);
                                                                                                for ($x = 1; $x <= $different_value; $x++) {
                                                                                                    array_pop($merge_grade);
                                                                                                }
                                                                                            }else{
//                                                                                            die('2');
                                                                                                foreach ($take_grade as $f) {
                                                                                                    $result = array_search("on", $take_grade);
                                                                                                    unset($take_grade[$result]);
                                                                                                }
//                                                                                        die(print_r($take_grade));
                                                                                                $merge_grade = array_merge($get_grade, $take_grade);
                                                                                            }
                                                                                        }else{
//                                                                                            die('2');
                                                                                            if (count(json_decode($request->Cgrade[0])) >= count($request->Cgrades)) {
//                                                                                                die('1');
                                                                                                $merge_grade = array_merge($get_grade,$take_grade);
                                                                                            }else{
//                                                                                                die('2');
                                                                                                foreach ($take_grade as $f) {
                                                                                                    $result = array_search("on", $take_grade);
                                                                                                    unset($take_grade[$result]);
                                                                                                }
//                                                                                            die(print_r(count($request->Cgrades)));
                                                                                                if (count($request->Cgrades) == 3){
                                                                                                    $different_value = count(json_decode($request->Cgrade[0])) - 4;
                                                                                                }elseif (count($request->Cgrades) == 2){
                                                                                                    $different_value = count(json_decode($request->Cgrade[0])) - 3;
                                                                                                }elseif (count($request->Cgrades) == 1){
                                                                                                    $different_value = count(json_decode($request->Cgrade[0])) - 2;
                                                                                                }else{
                                                                                                    $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                                                }
                                                                                                $merge_grade = array_merge($get_grade,$take_grade);
                                                                                                for ($x = 1; $x <= $different_value; $x++) {
                                                                                                    array_pop($merge_grade);
                                                                                                }
                                                                                            }

                                                                                        }

                                                                                    }
                                                                                }
                                                                            }else{
//                                                                                die('2');
                                                                                foreach ($take_grade as $f) {
                                                                                    $result = array_search("on", $take_grade);
                                                                                    unset($take_grade[$result]);
                                                                                }
                                                                                $merge_grade = array_merge($get_grade,$take_grade);
                                                                            }
                                                                        }

                                                                    }else{
                                                                        foreach ($take_grade as $f) {
                                                                            $result = array_search("on", $take_grade);
                                                                            unset($take_grade[$result]);
                                                                        }
                                                                        $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                        $different_value = $different_value -1;
                                                                        $merge_grade = array_merge($get_grade,$take_grade);
                                                                        for ($x = 1; $x <= $different_value; $x++) {
                                                                            array_pop($merge_grade);
                                                                        }
                                                                    }

                                                                }


                                                            }else{
//                                                                die('2');
                                                                $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                                                $merge_grade = array_merge($get_grade,$take_grade);
                                                                for ($x = 1; $x <= $different_value; $x++) {
                                                                    array_pop($merge_grade);
                                                                }
                                                            }

                                                        }else{
//                                                            die('2');
                                                            foreach ($take_grade as $f) {
                                                                $result = array_search("on", $take_grade);
                                                                unset($take_grade[$result]);
                                                            }
                                                            $merge_grade = array_merge($get_grade, $take_grade);
                                                        }

                                                    }

                                                }else{
//                                                    die('2');
                                                    foreach ($take_grade as $f) {
                                                        $result = array_search("on", $take_grade);
                                                        unset($take_grade[$result]);
                                                    }

                                                    $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
//                                                die(print_r($different_value));
                                                    $merge_grade = array_merge($get_grade,$take_grade);
                                                    for ($x = 1; $x <= $different_value; $x++) {
                                                        array_pop($merge_grade);
                                                    }
                                                }
                                            }

                                        }else{
//                                            die('2');
                                            foreach ($take_grade as $f) {
                                                $result = array_search("on", $take_grade);
                                                unset($take_grade[$result]);
                                            }
                                            $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
                                            $merge_grade = array_merge($get_grade,$take_grade);
                                            for ($x = 1; $x <= $different_value; $x++) {
                                                array_pop($merge_grade);
                                            }
                                        }

                                    }
                                }else{
//                                    die('2');
                                    $different_value = count(json_decode($request->Cgrade[0])) - count($request->Cgrades);
//                                die(print_r($different_value));
                                    $merge_grade = array_merge($get_grade,$take_grade);
                                    for ($x = 1; $x <= $different_value; $x++) {
                                        array_pop($merge_grade);
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $merge_grade = $get_grade;
                }
            }else{
                $merge_grade = $request->Cgrades;
            }
        }
        if($request->Cgrades[0] == "false"){
            $merge_grade = null;
        }
        // old Page //
//        if ($booking_schedule->grade_id) {
//            $take_grade = json_decode($booking_schedule->array_grade);
//            $new_take_grade = json_decode($request->Cgrade[0]);
//            // untuk mengatasi jika di refresh chorem maka data array tidak double
//            if(!empty($new_take_grade)) {
//                foreach ($new_take_grade as $index => $f) {
//                    if (!empty($take_grade) && !in_array($f, $take_grade)) {
//                        array_push($take_grade, $f);
//                        $merge_grade = $take_grade;
//                    } else {
//                        if (!empty($new_take_grade)){
//                            $merge_grade = json_encode(array($f));
//                        }else{
//                            $merge_grade = $take_grade;
//                        }
//                    }
//                }
//            }
//            // End untuk mengatasi jika di refresh chorem maka data array tidak double
//        }
        // End old Page //


//        if (!empty($request->passexpirydate)){
//            $passexpirydate = $request->passexpirydate;
//        }else{
//            $passexpirydate = null;
//        }
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
                ]);
        }else{
            $booking_schedule = booking_schedule::where(['nric' => Auth::user()->nric,'card_id'=>$request->card])
                ->update([
                    'app_type' => $request->app_type,
                    'card_id' => $request->card,
//                    'grade_id' => $grade,
//                    'array_grade' => $request->Cgrade[0],
                    'array_grade' => $merge_grade,
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
                ]);
        }

        return $booking_schedule;
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
//        if(isset($request['homeno']) && isset($request['mobileno']) && isset($request['wpexpirydate']) && !empty($request['homeno']) && !empty($request['mobileno'] && !empty($request['wpexpirydate']))){    $UpdateUser = User::find(Auth::id());
        $UpdateUser = User::find(Auth::id());

//        $UpdateUser->homeno = $request['homeno'];

        $UpdateUser->email = $request['email'];

        $UpdateUser->mobileno = $request['mobileno'];

        $UpdateUser->wpexpirydate = $request['wpexpirydate'];

        $UpdateUser->save();
    }elseif(isset($request['email']) && isset($request['mobileno'])  && !empty($request['email']) && !empty($request['mobileno'] )){
//    }elseif(isset($request['homeno']) && isset($request['mobileno'])  && !empty($request['homeno']) && !empty($request['mobileno'] )){
        $UpdateUser = User::find(Auth::id());

//        $UpdateUser->homeno = $request['homeno'];

        $UpdateUser->email = $request['email'];

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
        if ($agent->isDesktop() == true) {
            if ($request->mobileno[0] != "6" || $request->mobileno[1] != "5") {
                $mobileno = "65".$request->mobileno;
            }else{
                $mobileno = $request->mobileno;
            }
            $originData = array(
//                "homeno" => $request->homeno,
                "email" => $request->email,
                "wpexpirydate" => $request->wpexpirydate,
                "mobileno" => $mobileno
            );
        }else{
            if ($request->Phonemobileno[0] != "6" || $request->Phonemobileno[1] != "5") {
                $Phonemobileno = "65".$request->Phonemobileno;
            }else{
                $Phonemobileno = $request->mobileno;
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
}
