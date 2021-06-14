<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dateholiday extends Model
{
    protected $fillable = [
        'date', 'name_holiday', 'time_work'
    ];
}
