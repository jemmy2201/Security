<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backup_users extends Model
{
    protected $fillable = [
        'name', 'email', 'password','nric','passid','passportexpirydate','passexpirydate','passportnumber','mobileno','homeno','photo','time_login_at'
    ];
}
