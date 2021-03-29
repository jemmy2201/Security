<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction_amount extends Model
{
    protected $fillable = [
        'app_type', 'card_type', 'grade_id', 'transaction_amount'
    ];
}
