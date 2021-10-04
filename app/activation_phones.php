<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activation_phones extends Model
{
    protected $fillable = [
        'activation', 'status', 'nric'
    ];
}
