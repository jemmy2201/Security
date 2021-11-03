<?php

namespace App\Exports;

use App\booking_schedule;
use Carbon\Carbon;
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
        $booking_schedule = booking_schedule::select('users.nric','users.name','users.mobileno','users.homeno',
            'booking_schedules.passid','booking_schedules.app_type','booking_schedules.card_id',"grade_id",'booking_schedules.array_grade',
            "booking_schedules.Status_app","booking_schedules.declaration_date","booking_schedules.trans_date","booking_schedules.expired_date")
            ->leftJoin('users', 'booking_schedules.nric', '=', 'users.nric')->get();
        foreach($booking_schedule as $key => $f) {
              $booking_schedule[$key]->nric = base64_decode($f->nric);

//            if ($f->grade_id == so){
//                $booking_schedule[$key]->grade_id = 'SO';
//            }elseif ($f->grade_id == sso){
//                $booking_schedule[$key]->grade_id = 'SSO';
//            }elseif ($f->grade_id == sss){
//                $booking_schedule[$key]->grade_id = 'SSS';
//            }else{
//                $booking_schedule[$key]->grade_id = '';
//            }
//            if ($f->expired_date){
//                $booking_schedule[$key]->expired_date = Carbon::parse($f->expired_date)->format('d/n/Y');
//            }
//            if ($f->trans_date){
//                $booking_schedule[$key]->trans_date = Carbon::parse($f->trans_date)->format('d/n/Y h:i:s');
//            }
//            if ($f->declaration_date){
//                $booking_schedule[$key]->declaration_date = Carbon::parse($f->declaration_date)->format('d/n/Y');
//            }
        }
        return $booking_schedule;
    }

    public function headings(): array
    {
        return [
            'nric',
            'name',
            'mobile',
            'home',
            'passid',
            'app_type',
            'card_type',
            'grade',
            'array_grade',
            'status_app',
            'declaration_date',
            'transfer_date',
            'expiry_date',
        ];
    }
}
