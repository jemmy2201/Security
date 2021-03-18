<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $fillable = [
        'booking_id', 'cardz', 'status','user_id'
    ];

}
