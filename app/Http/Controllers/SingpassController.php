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
        $key =array(
                "kty"=> "RSA",
                "e"=> "AQAB",
                "use"=> "enc",
                "kid"=> "CgRfvss8Qw7BuTyLxSPyueurzMc=",
                "alg"=> "RSA-OAEP",
                "n"=> "lPmNltQXrer-6nzHs0CvGGdufw5AC-33tlbzfFjvSlulSSHQSeegU-KSqNkfnpAgMOMOD01MCpqg_SefhJ8pTapYIJdj1X8Df7t1GUzxD1TEHhQpIy0HvdYQgjl2TseNVirG9Vr4I78X_tG4hIyOewLKKqYGqBXDg41pg40QYPqsvAYJ8vZvg7lvyMaKPySnzVZFWEUtGrCXjfpkuImH_UmjdJU31drS1-YjfjMB6LZG7UMoY99nyf3y-_IHqraho5j2-3r5IZcg6nUznNp2NybGB1AG0YWCFqb-0BfBuaa9kuBVjjGe3iQSrRsDHGWA-8ZgOE7KhjTakQw_UPVXlw"
            );
        return $key;
    }
    public function dummy_login($type)
    {
        return view('login')->with(["type_dummy"=>$type]);

    }
}
