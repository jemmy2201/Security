<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Auth;

class SingpassController extends Controller
{
    public function login(Request $request)
    {
        $existingUser = User::where('passid',"S9812381D")->first();
        if($existingUser){
            auth()->login($existingUser, true);
            return redirect()->to('/home');
        }
        return redirect()->to('/');
    }
    public function jwks(){

    }
}
