<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class schedule_limit extends Model
{
    protected $fillable = [
        'date_schedule_limit','start_at', 'end_at', 'amount','status'
    ];

}
