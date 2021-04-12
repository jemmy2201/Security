<?php

namespace App\Exports;

use App\booking_schedule;
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
        return booking_schedule::select('users.nric','users.name','users.email','users.mobileno',DB::raw("CASE
                    WHEN app_type = 0 THEN 'NEW'
                    WHEN app_type = 1 THEN 'Replacement'
                    WHEN app_type = 2 THEN 'Renewal'
                    END AS app_type"),DB::raw(
                    "CASE
                    WHEN booking_schedules.card_id = 0 THEN 'SO Application'
                    WHEN booking_schedules.card_id = 1 THEN 'AVSO Application'
                    WHEN booking_schedules.card_id = 2 THEN 'PI Application'
                    END AS card_id"),"declaration_date",DB::raw('CONCAT(time_start_appointment, "-", time_end_appointment) AS time'))
                ->leftJoin('users', 'booking_schedules.user_id', '=', 'users.id')->get();
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
            'date',
            'time',
        ];
    }
}
