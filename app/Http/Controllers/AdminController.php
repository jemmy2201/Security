<?php

namespace App\Http\Controllers;

use App\t_grade;
use Illuminate\Http\Request;
use App\grade;
use App\gst;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function price()
    {
        $grade = grade::get();
        $t_grade = t_grade::get();
        return view('admin/price')->with(['t_grade'=>$t_grade,'grade'=>$grade]);
    }

    public function gst()
    {
        $gst = gst::first();
        return view('admin/gst')->with(['gst'=>$gst]);
    }
    public function change_pass()
    {
    return view('admin/change_pass');
    }

    public function limit_schedule()
    {
        return view('admin/limit_schedule');
    }
    public function holiday_table()
    {
        return view('admin/holiday_table');
    }
    public function upgrade_grade()
    {
        return view('admin/upgrade_grade');
    }
    public function upload_payment()
    {
        return view('staff/upload_payment');
    }
    public function historylogin()
    {
        return view('admin/historylogin');
    }
    public function security_employees()
    {
        return view('admin/security_employees');
    }
    public function appointment()
    {
        return view('admin/appointment');
    }
    public function course()
    {
        $t_grade = t_grade::get();

        return view('admin/course')->with(['t_grade'=>$t_grade]);
    }


}
