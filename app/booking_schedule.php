<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_schedule extends Model
{
    protected $fillable = [
        'start_at', 'end_at', 'application_type','application_id','detail_application_id','user_id'
    ];
}
