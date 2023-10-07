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
            return  view('page_error_SOQuery')->with(['type_error'=>type_error_so_query,'data1'=>value_SO_IDQuery1,'data2'=>value_SO_IDQuery2,'data3'=>value_SO_IDQuery3,'image'=>'fa fa-info-circle']);
        }else{
            return view('soquery')->with(["soquery" => $soquery]);
        }
    }
}
