<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    protected $fillable = [
        'card_id', 'name', 'bsoc', 'ssoc', 'sssc', 'created_by'
    ];
}
