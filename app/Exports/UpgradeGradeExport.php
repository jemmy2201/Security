<?php

namespace App\Exports;

use App\booking_schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class UpgradeGradeExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $booking_schedule = booking_schedule::select('users.nric','users.name','users.email',DB::raw("CASE
                                        WHEN app_type = 0 THEN 'NEW'
                                        WHEN app_type = 1 THEN 'Replacement'
                                        WHEN app_type = 2 THEN 'Renewal'
                                        END AS app_type"),DB::raw(
            "CASE
                                        WHEN booking_schedules.card_id = ".so_app." THEN 'SO Application'
                                        WHEN booking_schedules.card_id = ".avso_app." THEN 'AVSO Application'
                                        WHEN booking_schedules.card_id = ".pi_app." THEN 'PI Application'
                                        END AS card_id"),"grade_id")
            ->leftJoin('users', 'booking_schedules.user_id', '=', 'users.id')->get();
        foreach($booking_schedule as $key => $f) {
            if ($f->grade_id == so){
                $booking_schedule[$key]->grade_id = 'SO';
            }elseif ($f->grade_id == sso){
                $booking_schedule[$key]->grade_id = 'SSO';
            }elseif ($f->grade_id == sss){
                $booking_schedule[$key]->grade_id = 'SSS';
            }
        }
        return $booking_schedule;
    }

    public function headings(): array
    {
        return [
            'nric',
            'name',
            'email',
            'app_type',
            'card_type',
            'grade',
        ];
    }
}
