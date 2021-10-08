<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnetsController extends Controller
{
    public function frontend_response()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function backend_response(Request $request)
    {
        die(print_r($request->all()));
    }
}
