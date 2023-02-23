<?php

use App\booking_schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Enets
Route::post('/s2sTxnEndURL', 'EnetsController@s2sTxnEndURL');
Route::post('/b2sTxnEndURL', 'EnetsController@b2sTxnEndURL');
// End Enets

// jwe decrypted
Route::post('/jwe/decrypted', 'JWEController@private_key_jwe');
// end jwe decrypted

Route::post('/secret_encode',function(Request $request){
    $encode = secret_encode($request->id);
    return $encode;
});
Route::post('/secret_decode',function(Request $request){
    $decode = secret_decode($request->id);
    return $decode;
});

Route::post('/check/passid',function(Request $request){
    $data = booking_schedule::where(['passid' => $request->passid])->get();
    return $data;
});
