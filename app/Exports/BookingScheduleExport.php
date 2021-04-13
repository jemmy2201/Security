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
                                        WHEN booking_schedules.card_id = 0 THEN 'SO Application'
                                        WHEN booking_schedules.card_id = 1 THEN 'AVSO Application'
                                        WHEN booking_schedules.card_id = 2 THEN 'PI Application'
                                        END AS card_id"),"grade_id","declaration_date",DB::raw('CONCAT(time_start_appointment, "-", time_end_appointment) AS time'))
                                ->leftJoin('users', 'booking_schedules.user_id', '=', 'users.id')->get();
        foreach($booking_schedule as $key => $f) {
            foreach (json_decode($f->grade_id) as $g) {
                $grade = grade::where(['id'=>$g])->first();
                $grades[]= $grade->type;
            }
            if (count($grades) == 1){
                $booking_schedule[$key]->grade_id = $grades[0];
            }elseif (count($grades) == 2){
                $booking_schedule[$key]->grade_id = $grades[0].','.$grades[1];
            }elseif (count($grades) == 3){
                $booking_schedule[$key]->grade_id = $grades[0].','.$grades[1].','.$grades[2];
            }else{
                $booking_schedule[$key]->grade_id = $grades[0].','.$grades[1].','.$grades[2];
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
            'Nric / Fin',
            'Name',
            'Email',
            'Phone',
            'Application Type',
            'Request  Application',
            'Grade',
            'date',
            'time',
        ];
    }
}
