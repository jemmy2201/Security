<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SoQueryController extends Controller
{
    public function soquery($passid)
    {
        $soquery=DB::connection('usesocard')->table('use_so_card')->where(['PassID'=>$passid])->first();
        if (empty($soquery)){
            return  view('page_error')->with(['data'=>value_IDQuery,'image'=>'fa fa-info-circle']);
        }else{
            return view('soquery')->with(["soquery" => $soquery]);
        }
    }
}
