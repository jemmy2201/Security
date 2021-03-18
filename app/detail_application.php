<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_application extends Model
{
    protected $fillable = [
        'application_id', 'name', 'created_by'
    ];
}
