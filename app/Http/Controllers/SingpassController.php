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
        $key['keys'] =[array(
            "kty"=> "EC",
            "d"=> "AGscyf2X8C0VREczpb3E_yUVHNnr5DeuDD-YQqgRBsn9d9GML6iELO8OayDWas7kSMABFpxT_Nk0AK0OTMo1s7zp",
            "use"=> "sig",
            "crv"=>"P-521",
            "kid"=> "idx",
            "x"=> "AQUrwZ5XP8Dk_Ivj4u9ZJ7wPkIiTykeyy2VzkB39izR8is5jXnPBLbZUpSn30Y92U_XT8j-u-9lsPpPlUBhM2z6H",
            "y"=> "AFK8aR2UDfnhhTZcgcoB6-EGKzR_AWwMDOlljzzWDwkWrMsVs7WkUGTDFjkUMT3sZqm36k2s-Ppw_T4DAhiQ_wsg",
            "alg"=> "ES512"
            ),array(
            "kty"=> "EC",
            "d"=> "Af813aqlv539RquwDsaA86z9uHk1FvictvCc-NirMAeeT5pGq7Z121ErAjcOHlZCVOs-keiYcAumcG-dSulvwAJ0",
            "use"=> "enc",
            "crv"=> "P-521",
            "kid"=> "idx2",
            "x"=> "AfiIONfcS3x-klWcRYbsH9TmXvAiQOK6kOKEDyi6rYRW3ZQJCTX-feJu9I8lvB03bsfuNhk5EHjXqe4qP-BBS3Ae",
            "y"=> "AZS5Ngw4suPgKw6VvJvEz2-SmAbkJk-8iXycFcBLK0kdxIfhWZz3OBHDVBff1NZGamwjReZIeB0tAT9BG7J94H1e",
            "alg"=> "ECDH-ES+A256KW"
        )];
        return $key;
    }
    public function public_jwks(){
        $key_public['keys'] =[array(
            "kty"=> "EC",
            "use"=> "sig",
            "crv"=> "P-521",
            "kid"=> "idx",
            "x"=> "AQXQa4xh4OlMLuMC15eIA3IFyCMs8HU4o0I2vuQmpyT2yNoWGSFBIl8epClLE7sq4pnmHKAdYo6Cu0abVKwzJc0w",
            "y"=> "AMvcLWwzFCHsuTT2tEv_oy-recW7R4F_IbKtJMfUZkPu5NLRvCpRx1HCczRVcXjWcWjM5kNl7bSWq2dPsvClJ0g9",
            "alg"=> "ES512"
        ),array(
            "kty"=> "EC",
            "use"=> "enc",
            "crv"=> "P-521",
            "kid"=> "idx-EC",
            "x"=> "AWt1adYM5gdQBPd5muExnS2mDwsjCyU6z34R_02P51HOcYz7bHqdpmOVcbC_SYLuxF5i5x84mpN8epZixUMKnb4e",
            "y"=> "Aa7A61zY0875VY19L2KP9bWlPz4IspLjz4d2CrN5k5yss9keqXA8s_5fKtFAKL5p2oyNNzUIxbsb_CdA-xfQfS4Y",
            "alg"=> "ECDH-ES+A256KW"
        )];
        return $key_public;
    }
    public function dummy_login($type)
    {
        return view('login')->with(["type_dummy"=>$type]);

    }
}
