<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SoQueryController extends Controller
{
    public function soquery($passid)
    {
        $soquery=DB::connection('usesocard')->table('use_so_card')->where(['PassID'=>$passid])->first();
        return view('soquery')->with(["soquery" => $soquery]);
    }
}
