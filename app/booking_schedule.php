<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_schedule extends Model
{
    protected $fillable = [
        'app_type', 'card_id', 'grade_id','declaration_date','time_start_appointment','time_end_appointment',
        'trans_date','expired_date','appointment_date','gst_id','transaction_amount_id','paymentby',
        'status_payment','user_id','Status_draft','array_grade','bsoc','ssoc','sssc'
    ];
}
