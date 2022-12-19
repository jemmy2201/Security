<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;

use GuzzleHttp\Client;

use Jose\Factory\JWKFactory;
use Jose\Loader;
use Jose\Object\JWKSet;
use Artisan;
use Illuminate\Support\Facades\Http;
use Jose\Factory\JWSFactory;
use EllipticCurve;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\Serializer\CompactSerializer;
use SimpleJWT;

class SingpassController extends Controller
{
    public static function newuser($sub)
    {
        $time = Carbon::now();

        $web = false;
        if (substr($sub,0,1) == work_permit_pass || substr($sub,0,1) == employment_pass){
            $web = true;
        }
        // Email Default
        $count_user = User::count();
        $email = 'example'.$count_user.'@example.com';
        // End Email Default
        $InUser = new User;

        $InUser->name = '-';

        $InUser->email = $email;

        $InUser->password = Hash::make(default_pass);

//        $InUser->nric =$response['sponsoredchildrenrecords'][0]['nric']['value'];

        $InUser->nric =secret_encode($sub);

//        $InUser->passid =$response['uinfin']['value'];

//        $InUser->passportexpirydate =$response['passportexpirydate']['value'];

//        $InUser->passexpirydate =$response['passportexpirydate']['value'];

//        $InUser->passportnumber =$response['passportnumber']['value'];

//        $InUser->mobileno =$response['mobileno']['prefix']['value'].''.$response['mobileno']['areacode']['value'].''.'-'.$response['mobileno']['nbr']['value'];

//        $InUser->homeno =$response['homeno']['prefix']['value'].''.$response['homeno']['areacode']['value'].''.'-'.$response['homeno']['nbr']['value'];

//        $InUser->photo =$response['drivinglicence']['photocardserialno']['value'];

        $InUser->web =$web;

        $InUser->time_login_at =$time->toDateTimeString();

        $InUser->save();

       return $InUser;
    }
    protected  function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function private_key_jwt()
    {
        // genereta online (https://keytool.online/)
        $privateKey= file_get_contents('PrivateKey.pem');
        // End genereta online (https://keytool.online/)
        $Exp_encode   = Carbon::now()->addMinutes('2')->timestamp;
        $Iat_encode   = Carbon::now()->timestamp;

        if (detect_url() == URLUat){
            $clientIdSinpass = clientIdSinpassUat;
            $aud = audUat;
        }elseif (detect_url() == URLProd){
            $clientIdSinpass = clientIdSinpassProd;
            $aud = audProd;
        }else{
            $clientIdSinpass = clientIdSinpassUat;
            $aud = audUat;
        }

        $payload = array(
            "sub" => $clientIdSinpass,
            "aud" => $aud,
            "iss" => $clientIdSinpass,
            "iat" => $Iat_encode,
            "exp" => $Exp_encode
        );

        $jwt = JWT::encode($payload, $privateKey,'ES256');

        return $jwt;
    }
    public static function api_private_key_jwe($response)
    {
        $ch = curl_init( url_api_private_key_jwe );
        # Setup request to send json via POST.
        $payload = json_encode( array( "code"=> $response ) );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    public static function private_key_jwe($response)
    {
//        if (detect_url() == URLUat){
//            $jwks_uri_ec_local = static::private_get_jwks_ec_local();
//
//            $jwk = JWKFactory::createFromValues($jwks_uri_ec_local);
//
//            $recipient_index=[];
//
//            $loader = new Loader();
//            // This is the input we want to load verify.
//            // $response = 'eyJhbGciOiJSU0EtT0FFUCIsImtpZCI6InNhbXdpc2UuZ2FtZ2VlQGhvYmJpdG9uLmV4YW1wbGUiLCJlbmMiOiJBMjU2R0NNIn0.rT99rwrBTbTI7IJM8fU3Eli7226HEB7IchCxNuh7lCiud48LxeolRdtFF4nzQibeYOl5S_PJsAXZwSXtDePz9hk-BbtsTBqC2UsPOdwjC9NhNupNNu9uHIVftDyucvI6hvALeZ6OGnhNV4v1zx2k7O1D89mAzfw-_kT3tkuorpDU-CpBENfIHX1Q58-Aad3FzMuo3Fn9buEP2yXakLXYa15BUXQsupM4A1GD4_H4Bd7V3u9h8Gkg8BpxKdUV9ScfJQTcYm6eJEBz3aSwIaK4T3-dwWpuBOhROQXBosJzS1asnuHtVMt2pKIIfux5BC6huIvmY7kzV7W7aIUrpYm_3H4zYvyMeq5pGqFmW2k8zpO878TRlZx7pZfPYDSXZyS0CfKKkMozT_qiCwZTSz4duYnt8hS4Z9sGthXn9uDqd6wycMagnQfOTs_lycTWmY-aqWVDKhjYNRf03NiwRtb5BE-tOdFwCASQj3uuAgPGrO2AWBe38UjQb0lvXn1SpyvYZ3WFc7WOJYaTa7A8DRn6MC6T-xDmMuxC0G7S2rscw5lQQU06MvZTlFOt0UvfuKBa03cxA_nIBIhLMjY2kOTxQMmpDPTr6Cbo8aKaOnx6ASE5Jx9paBpnNmOOKH35j_QlrQhDWUN6A2Gg8iFayJ69xDEdHAVCGRzN3woEI2ozDRs.-nBoKLH0YkLZPSI9.o4k2cnGN8rSSw3IDo1YuySkqeS_t2m1GXklSgqBdpACm6UJuJowOHC5ytjqYgRL-I-soPlwqMUf4UgRWWeaOGNw6vGW-xyM01lTYxrXfVzIIaRdhYtEMRBvBWbEwP7ua1DRfvaOjgZv6Ifa3brcAM64d8p5lhhNcizPersuhw5f-pGYzseva-TUaL8iWnctc-sSwy7SQmRkfhDjwbz0fz6kFovEgj64X1I5s7E6GLp5fnbYGLa1QUiML7Cc2GxgvI7zqWo0YIEc7aCflLG1-8BboVWFdZKLK9vNoycrYHumwzKluLWEbSVmaPpOslY2n525DxDfWaVFUfKQxMF56vn4B9QMpWAbnypNimbM8zVOw.UCGiqJxhBI3IFVdPalHHvA';
//            // The payload is decrypted using our key.
//            $jwe = $loader->loadAndDecryptUsingKey(
//                $response,            // The input to load and decrypt
//                $jwk,                 // The symmetric or private key
//                ['ECDH-ES+A128KW'],      // A list of allowed key encryption algorithms
//                ['A256CBC-HS512'],       // A list of allowed content encryption algorithms
//                $recipient_index   // If decrypted, this variable will be set with the recipient index used to decrypt
//            );
//            $jwe = (array) $jwe;
//        }elseif (detect_url() == URLProd) {
            $jwe = static::api_private_key_jwe($response);
//        }
        return $jwe;
    }
    public static function public_key_jwt($response)
    {

//        if (detect_url() == URLUat){
//            // genereta online (https://keytool.online/) this key $jwks_uri
//            $publicKey= file_get_contents('PublicKey.pem');
//            // genereta online (https://keytool.online/)
//
//            $decoded = JWT::decode($response, $publicKey, array('ES256'));
//            $decoded_array = (array) $decoded;
//        }elseif (detect_url() == URLProd) {

            $jwk = new JWK([
                "kty"=> "EC",
                "d"=> "rTMBv7X9HgJfRjZCqyv6XQbOOk-G5C85tIRssTPnhLM",
                "use"=> "sig",
                "crv"=> "P-256",
                "kid"=> "idx-sig",
                "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
                "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
            ]);

            // The serializer manager. We only use the JWS Compact Serialization Mode.
            $serializerManager = new JWSSerializerManager([
                new CompactSerializer(),
            ]);


            // We try to load the token.
            $jws = $serializerManager->unserialize($response);

            // We verify the signature. This method does NOT check the header.
            // The arguments are:
            // - The JWS object,
            // - The key,
            // - The index of the signature to check. See
            $decoded_array = (array)$jws;

//        }

        return $decoded_array;

    }

    public static function auth_req_id($jwt)
    {
        if (detect_url() == URLUat){
            $authApiUrl = auth_req_idUrlUat;
            $host = hostUat;
        }elseif (detect_url() == URLProd){
            $authApiUrl = auth_req_idUrlProd;
            $host = hostProd;
        }else{
            $authApiUrl = auth_req_idUrlUat;
            $host = hostUat;
        }

        $data = 'client_assertion='.$jwt.'&client_assertion_type=urn:ietf:params:oauth:client-assertion-type:jwt-bearer&scope=openid&login_hint=S3002114b';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$authApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type: application/x-www-form-urlencoded','Accept-Charset : ISO-8859-1','Host :'.$host.''));

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch);

        return $response;
    }

    public static function id_token($jwt,$code)
    {
        if (detect_url() == URLUat){
            $authApiUrl = authApiUrlUat;
            $clientIdSinpass = clientIdSinpassUat;
            $redirectUrlSingpassCurl = redirectUrlSingpassCurlUat;
            $host = hostUat;
        }elseif (detect_url() == URLProd){
            $authApiUrl = authApiUrlProd;
            $clientIdSinpass = clientIdSinpassProd;
            $redirectUrlSingpassCurl = redirectUrlSingpassCurlProd;
            $host = hostProd;
        }else{
            $authApiUrl = authApiUrlUat;
            $clientIdSinpass = clientIdSinpassUat;
            $redirectUrlSingpassCurl = redirectUrlSingpassCurlUat;
            $host = hostUat;
        }

        $data = 'client_assertion_type=urn:ietf:params:oauth:client-assertion-type:jwt-bearer&client_assertion='.$jwt.'&client_id='.$clientIdSinpass.'&grant_type=authorization_code&redirect_uri='.$redirectUrlSingpassCurl.'&code='.$code.'&scope=openid';
//        $data = 'auth_req_id='.$auth_req_id.'&grant_type=urn:openid:params:grant-type:ciba&client_assertion_type=urn:ietf:params:oauth:client-assertion-type:urn:ietf:params:oauth:client-assertion-type:jwt-bearer&client_assertion='.$jwt.'';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $authApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Charset: ISO-8859-1',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public static function configuration_singpass()
    {
        if (detect_url() == URLUat){
            $authApiUrlSingpassconfiguration = authApiUrlSingpassconfigurationUat;
        }elseif (detect_url() == URLProd){
            $authApiUrlSingpassconfiguration = authApiUrlSingpassconfigurationProd;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$authApiUrlSingpassconfiguration);

        $response=curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }



    public static function private_get_jwks_ec_local()
    {

        if (detect_url() == URLUat){
            $urlec = urlecUat;
        }elseif (detect_url() == URLProd){
            $urlec = urlecProd;
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$urlec);

        $response =curl_exec($ch);

        curl_close($ch);

        $jwks_uri = json_decode($response);

        $response = json_decode(json_encode($jwks_uri->keys[0]), true);

        return $response;
    }

    public static function public_private_get_jwks_sig_local()
    {

        if (detect_url() == URLUat){
            $urlec = urlpublicprivatecsigUat;
        }elseif (detect_url() == URLProd){
            $urlec = urlsigProd;
        }else{
            $urlec = urlsigProd;

        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$urlec);

        $response =curl_exec($ch);

        curl_close($ch);

        $response = json_decode($response,true);

        return $response;
    }

    public static function private_get_jwks_sig_local()
    {

        if (detect_url() == URLUat){
            $urlec = urlecUat;
        }elseif (detect_url() == URLProd){
            $urlec = urlecProd;
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$urlec);

        $response =curl_exec($ch);

        curl_close($ch);

        $jwks_uri = json_decode($response);

        $response = json_decode(json_encode($jwks_uri->keys[0]), true);

        return $response;
    }

    public static function public_get_jwks_sig_local()
    {

        if (detect_url() == URLUat){
            $urlec = urlecUat;
        }elseif (detect_url() == URLProd){
            $urlec = urlecProd;
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$urlec);

        $response =curl_exec($ch);

        curl_close($ch);

        $jwks_uri = json_decode($response);

        $response = json_decode(json_encode($jwks_uri->keys[0]), true);

        return $response;
    }

    public static function get_jwks_uri($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$url);

        $response =curl_exec($ch);

        curl_close($ch);

        $jwks_uri = json_decode($response);

        $response = json_decode(json_encode($jwks_uri->keys[0]), true);

        return $response;
    }
    protected function existingUsers($existingUser)
    {
        auth()->login($existingUser, true);

        return redirect()->to('/home');
    }
    public static function validasiUser($sub)
    {
        $existingUser = User::where('nric',secret_encode($sub))->first();

        if($existingUser){
            return true;
        }else{
            $newuser = static::newuser($sub);
            if ($newuser){
                return true;
            }else{
                return false;
            }
        }
    }
    public static function convert_sub($sub)
    {
        $Choose_sub =$sub;
        $explode_sub = explode(",", $Choose_sub);
        $final_sub = $explode_sub[0];
        $sub = substr($final_sub,2);
        return $sub;
    }
    public function login(Request $request)
    {
        $jwt = static::private_key_jwt();

//        $auth_req_id = static::auth_req_id($jwt);
//        die(print_r($auth_req_id));
        $response = static::id_token($jwt,$request->code);

//        if (detect_url() == URLUat){
            $data = json_decode($response)->id_token;
//        }elseif (detect_url() == URLProd){
//            $data = json_decode($response, true);
//            $data = $data['id_token'];
//        }

        $jwe_decode = static::private_key_jwe($data);

//        if (detect_url() == URLUat){
//            $jwe_decode = $jwe_decode["\x00Jose\Object\JWE\x00payload"];
//        }elseif (detect_url() == URLProd){
//            $jwe_decode = $jwe_decode;
//        }

        $jwt_decode = static::public_key_jwt($jwe_decode);
//        if (detect_url() == URLUat){
//            $sub = $jwt_decode['sub'];
//        }elseif (detect_url() == URLProd){
            $sub = $jwt_decode["\x00Jose\Component\Signature\JWS\x00payload"] ;
            $subs = json_decode($sub);
            $sub = $subs->sub;
//        }

        $sub = static::convert_sub($sub);

//        $validasiUser = static::validasiUser($sub);

//        if ($validasiUser == true){
//        }

            $existingUser = User::join('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
                            ->where('users.nric',secret_encode($sub))->get();

            if(count($existingUser) > 0) {
                foreach ($existingUser as $f) {
                    // Less 3 month
                    $expired_date = date('Y-m-d', strtotime(Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d'). ' - 3 months'));
                    if (Carbon::today()->toDateString() >= $expired_date) {
                        return  view('page_error')->with(['data1'=>expired_less_3month,'data2'=>value_not_found2,'image'=>'fa fa-info-circle']);
                    }
                    // End Less 3 month
                    if ($f->card_id == so_app && Carbon::today()->toDateString() >= Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d')) {
                        $cek_avso_PI = User::join('booking_schedules', 'users.nric', '=', 'booking_schedules.nric')
                            ->where(function ($query) {
                                $query->where(['booking_schedules.card_id'=>avso_app])
                                    ->orWhere(['booking_schedules.card_id'=>pi_app]);
                            })->where(['users.nric'=> secret_encode( $request->singpass_id )])->get();
                        if (count($cek_avso_PI) == 0){
//                            return  view('page_error')->with(['data'=>value_expired_card,'image'=>'fa fa-info-circle']);
                            return  view('page_error')->with(['data1'=>value_expired_card1,'data2'=>value_expired_card1,'image'=>'fa fa-info-circle']);
                        }else{
                            foreach ($cek_avso_PI as $f) {
                                if ($f->card_issue == n_card_issue){
//                                    return  view('page_error')->with(['data'=>value_card_issue,'image'=>'fa fa-info-circle']);
                                    return  view('page_error')->with(['data1'=>value_expired_card1,'data2'=>value_expired_card2,'image'=>'fa fa-info-circle']);
                                }else{
                                    $data = User::where('nric', secret_encode($request->singpass_id))->first();
                                }
                            }
                        }
                    }elseif ($f->card_issue == n_card_issue){
//                        return  view('page_error')->with(['data'=>value_card_issue,'image'=>'fa fa-info-circle']);
                        return  view('page_error')->with(['data1'=>value_expired_card1,'data2'=>value_expired_card1,'image'=>'fa fa-info-circle']);
                    }else{
                        $existingUser = User::where('nric',secret_encode($sub))->first();
                        auth()->login($existingUser, true);
                        return redirect()->to('/home');
                    }
                }
            } else{
//                return  view('page_error')->with(['data'=>'Your record not found. Please contact Union Of Security Employees for further assistance.','image'=>'fa fa-info-circle']);
                return  view('page_error')->with(['data1'=>value_not_found1,'data2'=>value_not_found2,'image'=>'fa fa-info-circle']);
            }

    }

    public function jwks(){
        $key['keys'] =[array(
            "kty"=> "EC",
            "use"=> "sig",
            "crv"=> "P-256",
            "kid"=> "idx-sig",
            "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
            "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
            "alg"=> "ES256"
        ),array(
            "kty"=> "EC",
            "use"=> "enc",
            "crv"=> "P-256",
            "kid"=> "idx-enc",
            "x"=> "9Is-VbNwtijojiwRxWAbXxg-UTndznGFISU0RlQpfoY",
            "y"=> "t67FS3cT-sohO_x5qsBvAnM5HTNkk_wNQza32YJg-6A",
            "alg"=> "ECDH-ES+A128KW"
        )];
        return $key;
    }
    public function private_key_ec(){
        $key['keys'] =[array(
            "kty"=> "EC",
            "d"=> "7FaRgw1cJmzGA1hss0YcLK4483zkKJ6JPafOwEoMlIw",
            "use"=> "enc",
            "crv"=> "P-256",
            "kid"=> "idx-enc",
            "x"=> "9Is-VbNwtijojiwRxWAbXxg-UTndznGFISU0RlQpfoY",
            "y"=> "t67FS3cT-sohO_x5qsBvAnM5HTNkk_wNQza32YJg-6A",
            "alg"=> "ECDH-ES+A128KW"
        )];
        return $key;
    }

    public function public_private_key_sig(){
        $key['keys'] =[array(
            "kty"=> "EC",
            "d"=> "rTMBv7X9HgJfRjZCqyv6XQbOOk-G5C85tIRssTPnhLM",
            "use"=> "sig",
            "crv"=> "P-256",
            "kid"=> "idx-sig",
            "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
            "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
//            "alg"=> "ES256"
        ),array(
            "kty"=> "EC",
            "d"=> "rTMBv7X9HgJfRjZCqyv6XQbOOk-G5C85tIRssTPnhLM",
            "use"=> "sig",
            "crv"=> "P-256",
            "kid"=> "idx-sig",
            "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
            "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
//            "alg"=> "ES256"
        )];
        return $key;
    }

    public function private_key_sig(){
        $key['keys'] =[array(
            "kty"=> "EC",
            "d"=> "rTMBv7X9HgJfRjZCqyv6XQbOOk-G5C85tIRssTPnhLM",
//            "use"=> "sig",
            "crv"=> "P-256",
            "kid"=> "idx-sig",
            "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
            "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
//            "alg"=> "ES256"
        )];
        return $key;
    }

    public function public_key_sig(){
        $key['keys'] =[array(
            "kty"=> "EC",
//            "d"=> "rTMBv7X9HgJfRjZCqyv6XQbOOk-G5C85tIRssTPnhLM",
//            "use"=> "sig",
            "crv"=> "P-256",
            "kid"=> "idx-sig",
            "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
            "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
//            "alg"=> "ES256"
        )];
        return $key;
    }

    public function dummy_login($type)
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Auth::logout();
        return view('login')->with(["type_dummy"=>$type]);

    }
}
