<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class so_update_info extends Model
{
    protected $table = 'so_update_info';
    public $timestamps = false;
    protected $fillable = [
        'PassID', 'NRIC', 'Name','Grade','New_Grade','TR_RTT','TR_CSSPB','TR_CCTC','TR_HCTA','TR_X_RAY','SKILL_BFM','SKILL_BSS','SKILL_FSM','SKILL_CERT','SKILL_COSEM','Date_Submitted'
    ];
}
