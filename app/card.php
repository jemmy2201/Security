<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class card extends Model
{
    protected $fillable = [
        'name', 'created_by'
    ];
}
