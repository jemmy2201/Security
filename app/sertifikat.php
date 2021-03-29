<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sertifikat extends Model
{
    protected $fillable = [
        'app_type', 'card_id', 'grade_id','declaration_date','trans_date','expired_date','appointment_date','gst','grand_gst','transaction_amount','grand_total','paymentby','status_payment','user_id'
    ];
}
