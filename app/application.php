<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    protected $fillable = [
        'name', 'created_by'
    ];
}
