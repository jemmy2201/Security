<?php

namespace App\Exports;

use App\booking_schedule;
use App\grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use function GuzzleHttp\Promise\all;

class BookingScheduleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $booking_schedule = booking_schedule::select('users.nric','users.name','users.email','users.mobileno',DB::raw("CASE
                                        WHEN app_type = 0 THEN 'NEW'
                                        WHEN app_type = 1 THEN 'Replacement'
                                        WHEN app_type = 2 THEN 'Renewal'
                                        END AS app_type"),DB::raw(
                                "CASE
                                        WHEN booking_schedules.card_id = ".so_app." THEN 'SO Application'
                                        WHEN booking_schedules.card_id = ".avso_app." THEN 'AVSO Application'
                                        WHEN booking_schedules.card_id = ".pi_app." THEN 'PI Application'
                                        END AS card_id"),"grade_id","declaration_date",DB::raw('CONCAT(time_start_appointment, "-", time_end_appointment) AS time'))
                                ->leftJoin('users', 'booking_schedules.user_id', '=', 'users.id')->get();
        foreach($booking_schedule as $key => $f) {
//            foreach (json_decode($f->grade_id) as $g) {
//                $grade = grade::where(['id'=>$g])->first();
//                $grades[]= $grade->type;
//            }

//            if (count($grades) == 1){
//                $booking_schedule[$key]->grade_id = $grades[0];
//            }elseif (count($grades) == 2){
//                $booking_schedule[$key]->grade_id = $grades[0].','.$grades[1];
//            }elseif (count($grades) == 3){
//                $booking_schedule[$key]->grade_id = $grades[0].','.$grades[1].','.$grades[2];
//            }else{
//                $booking_schedule[$key]->grade_id = $grades[0].','.$grades[1].','.$grades[2];
//            }
            if ($f->grade_id == so){
               $booking_schedule[$key]->grade_id = 'SO';
            }elseif ($f->grade_id == sso){
                $booking_schedule[$key]->grade_id = 'SSO';
            }elseif ($f->grade_id == ss){
                $booking_schedule[$key]->grade_id = 'SS';
            }elseif ($f->grade_id == sss){
                $booking_schedule[$key]->grade_id = 'SSS';
            }elseif ($f->grade_id == cso){
                $booking_schedule[$key]->grade_id = 'CSO';
            }
        }
        return $booking_schedule;
//        return booking_schedule::select('users.nric','users.name','users.email','users.mobileno',DB::raw("CASE
//                    WHEN app_type = 0 THEN 'NEW'
//                    WHEN app_type = 1 THEN 'Replacement'
//                    WHEN app_type = 2 THEN 'Renewal'
//                    END AS app_type"),DB::raw(
//                    "CASE
//                    WHEN booking_schedules.card_id = 0 THEN 'SO Application'
//                    WHEN booking_schedules.card_id = 1 THEN 'AVSO Application'
//                    WHEN booking_schedules.card_id = 2 THEN 'PI Application'
//                    END AS card_id"),"declaration_date",DB::raw('CONCAT(time_start_appointment, "-", time_end_appointment) AS time'))
//                ->leftJoin('users', 'booking_schedules.user_id', '=', 'users.id')->get();
    }
    public function headings(): array
    {
        return [
            'nric',
            'name',
            'email',
            'phone',
            'app_type',
            'card_type',
            'grade',
            'date',
            'time',
        ];
    }
}
