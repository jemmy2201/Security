<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dateholiday extends Model
{
    protected $fillable = [
        'date', 'holi_type', 'half'
    ];
}
