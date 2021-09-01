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
class SingpassController extends Controller
{
    public static function entity_person($response)
    {
        $data = [
            'client_assertion_type' => "urn:ietf:params:oauth:client-assertion-type:jwt-bearer",
            'client_assertion' => $jwt,
            'client_id' => clientIdSinpass,
            'grant_type' => "authorization_code",
            'redirect_uri' => redirectUrlSingpass,
            'code' => $request->code,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => authApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "charset: ISO-8859-1",
                "Host: stg-id.singpass.gov.sg",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
    public static function newuser($response)
    {
        $person = static::entity_person($response);

        $time = Carbon::now();

        $web = false;
        if (substr($response['uinfin']['value'],0,1) == work_permit_pass || substr($response['uinfin']['value'],0,1) == employment_pass){
            $web = true;
        }

        $InUser = new User;

        $InUser->name = $response['aliasname']['value'];

        $InUser->email = $response['email']['value'];

        $InUser->password = Hash::make($request->password);

//        $InUser->nric =$response['sponsoredchildrenrecords'][0]['nric']['value'];
        $InUser->nric =$response['uinfin']['value'];

//        $InUser->passid =$response['uinfin']['value'];

        $InUser->passportexpirydate =$response['passportexpirydate']['value'];

//        $InUser->passexpirydate =$response['passportexpirydate']['value'];

        $InUser->passportnumber =$response['passportnumber']['value'];

        $InUser->mobileno =$response['mobileno']['prefix']['value'].''.$response['mobileno']['areacode']['value'].''.'-'.$response['mobileno']['nbr']['value'];

        $InUser->homeno =$response['homeno']['prefix']['value'].''.$response['homeno']['areacode']['value'].''.'-'.$response['homeno']['nbr']['value'];

        $InUser->photo =$response['drivinglicence']['photocardserialno']['value'];

        $InUser->web =$web;

        $InUser->time_login_at =$time->toDateTimeString();

        $InUser->save();

        return $InUser;
    }
    protected  function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function private_key()
    {
        $privateKey= file_get_contents('PrivateKey.pem');
        $Exp_encode   = Carbon::now()->addMinutes('2')->timestamp;
        $Iat_encode   = Carbon::now()->timestamp;

        $payload = array(
            "sub" => clientIdSinpass,
            "aud" => "https://stg-id.singpass.gov.sg",
            "iss" => clientIdSinpass,
            "iat" => $Iat_encode,
            "exp" => $Exp_encode
        );

        $jwt = JWT::encode($payload, $privateKey,'ES256');

        return $jwt;
    }

    public static function public_key($response)
    {
//        $publicKey= file_get_contents('PrivateKey_Jwe.pem');
//
//        $decoded = JWT::decode($response, $publicKey, array('ES256'));
//        $decoded_array = (array) $decoded;
//        return $decoded_array;

        $jwk = JWKFactory::createKey([
            "kty"=> "EC",
            "d"=> "7FaRgw1cJmzGA1hss0YcLK4483zkKJ6JPafOwEoMlIw",
            "use"=> "enc",
            "crv"=> "P-256",
            "kid"=> "idx-enc",
            "x"=> "9Is-VbNwtijojiwRxWAbXxg-UTndznGFISU0RlQpfoY",
            "y"=> "t67FS3cT-sohO_x5qsBvAnM5HTNkk_wNQza32YJg-6A",
            "alg"=> "ECDH-ES+A128KW"
        ]);
        $recipient_index="";
        $loader = new Loader();
        // This is the input we want to load verify.
        // $response = 'eyJhbGciOiJSU0EtT0FFUCIsImtpZCI6InNhbXdpc2UuZ2FtZ2VlQGhvYmJpdG9uLmV4YW1wbGUiLCJlbmMiOiJBMjU2R0NNIn0.rT99rwrBTbTI7IJM8fU3Eli7226HEB7IchCxNuh7lCiud48LxeolRdtFF4nzQibeYOl5S_PJsAXZwSXtDePz9hk-BbtsTBqC2UsPOdwjC9NhNupNNu9uHIVftDyucvI6hvALeZ6OGnhNV4v1zx2k7O1D89mAzfw-_kT3tkuorpDU-CpBENfIHX1Q58-Aad3FzMuo3Fn9buEP2yXakLXYa15BUXQsupM4A1GD4_H4Bd7V3u9h8Gkg8BpxKdUV9ScfJQTcYm6eJEBz3aSwIaK4T3-dwWpuBOhROQXBosJzS1asnuHtVMt2pKIIfux5BC6huIvmY7kzV7W7aIUrpYm_3H4zYvyMeq5pGqFmW2k8zpO878TRlZx7pZfPYDSXZyS0CfKKkMozT_qiCwZTSz4duYnt8hS4Z9sGthXn9uDqd6wycMagnQfOTs_lycTWmY-aqWVDKhjYNRf03NiwRtb5BE-tOdFwCASQj3uuAgPGrO2AWBe38UjQb0lvXn1SpyvYZ3WFc7WOJYaTa7A8DRn6MC6T-xDmMuxC0G7S2rscw5lQQU06MvZTlFOt0UvfuKBa03cxA_nIBIhLMjY2kOTxQMmpDPTr6Cbo8aKaOnx6ASE5Jx9paBpnNmOOKH35j_QlrQhDWUN6A2Gg8iFayJ69xDEdHAVCGRzN3woEI2ozDRs.-nBoKLH0YkLZPSI9.o4k2cnGN8rSSw3IDo1YuySkqeS_t2m1GXklSgqBdpACm6UJuJowOHC5ytjqYgRL-I-soPlwqMUf4UgRWWeaOGNw6vGW-xyM01lTYxrXfVzIIaRdhYtEMRBvBWbEwP7ua1DRfvaOjgZv6Ifa3brcAM64d8p5lhhNcizPersuhw5f-pGYzseva-TUaL8iWnctc-sSwy7SQmRkfhDjwbz0fz6kFovEgj64X1I5s7E6GLp5fnbYGLa1QUiML7Cc2GxgvI7zqWo0YIEc7aCflLG1-8BboVWFdZKLK9vNoycrYHumwzKluLWEbSVmaPpOslY2n525DxDfWaVFUfKQxMF56vn4B9QMpWAbnypNimbM8zVOw.UCGiqJxhBI3IFVdPalHHvA';
        // The payload is decrypted using our key.
        $jws = $loader->loadAndDecryptUsingKey(
            $response,            // The input to load and decrypt
            $jwk,              // The symmetric or private key
            ['ECDH-ES+A128KW'],      // A list of allowed key encryption algorithms
            ['A256CBC-HS512'],       // A list of allowed content encryption algorithms
            $recipient_index   // If decrypted, this variable will be set with the recipient index used to decrypt
        );
        die(print_r($jws));
    }

    public static function id_token($jwt,$code)
    {
        $data = 'client_assertion_type=urn:ietf:params:oauth:client-assertion-type:jwt-bearer&client_assertion='.$jwt.'&client_id='.clientIdSinpass.'&grant_type=authorization_code&redirect_uri='.redirectUrlSingpassCurl.'&code='.$code.'';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,authApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','Accept-Charset : ISO-8859-1','Host :stg-id.singpass.gov.sg'));


        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch);

        return $response;
    }
    public function login(Request $request)
    {

        $jwt = static::private_key();
//        $data_person = static::public_key($jwt);

        $response = static::id_token($jwt,$request->code);

        $response = '{"access_token":"AJ9rwxnSEQoGMhb88WRysjgkgJXjFBvmUJQwAb1jspM=","token_type":"Bearer","id_token":"eyJlcGsiOnsia3R5IjoiRUMiLCJjcnYiOiJQLTI1NiIsIngiOiJobEpYelBxUzh3UkNfWVRtR2pyZS1VcGwzZ01fSHNpaUE1cXVZbUhRRG1rIiwieSI6IkxhU3VpWWhiVjZfaThyYUI1YWh0MUl4OVdJUi1KVXJHckk2TzA3NWNvYVkifSwia2lkIjoiaWR4LWVuYyIsImN0eSI6IkpXVCIsImVuYyI6IkEyNTZDQkMtSFM1MTIiLCJhbGciOiJFQ0RILUVTK0ExMjhLVyJ9.sUxsxMwoIPCujLCCM90H1A5Yxk-UoMrUiLtsBXc-lQoDdNIXlC1S05exPWpeDiGdlkpE3XdBkx7Kuwz4dDJnXppJA0CkVpZr.VLnOOe5XKxxCH3yCYBYkoQ.Dsy7APr5O437Dnl47M5-LLr7W8FZ8XvQluPRtg25FMyLklGZL_1GpjRveAWB3eOcz5j4hGG2PUj772EQUDYwJODypkhYA_DGd3Z64czkVjh8--Y0C2oPIQyIetQvqqKE-pCzcXOFjRS5JeYCfOTKUfB_VfWlfQFk78FErh5WiQ-KHx0zxZN_Giwd5wJc9NTCsZdi44sOP2wkAdxrzDwIFbKCyqFhShuo7qxF4Lhk2ZGmdp286FTwHm-B5enw4Sre41Z5jnDRI6h1RrPwQ-f5lwpqTNAW2DsIQGEi-MqyLW2D3VncUK6BzGAmApXGx-_A66kxVcbJMiuVu3DmdmURmCWWuSuGwc7pWW-Xsj6AIrP5vkoPsUr3yzC-3-YG3BvXgePVAmt7t13aDV84oaMwZTZonY4RIuBo9rNzsoUgY6OEQIQ_9pt5BK-dJLFht5n0vRByIBR2vMkC6l5jHOa67JsX9YibzTOLmM6DBFKF3upkG4iz1Bz3mGrJ9c0Bl2L5uu6hemXA6g1Tcl4Aer8SUuuK8PKAfFXNW_3dHr9IPP5qGZYDIvR-rCqcZER5aeX7vVn16kGFf0iq0QYYEIcbooCfCeTyndP6EKUwKQ-YfXU.PER2yEIojruD4mVzlf8Kd5aNuBROL6EOP3v6LKpsTlg"}';
//        die(print_r(json_decode($response)->id_token));

        $data_person = static::public_key(json_decode($response)->id_token);

        die(print_r($data_person));

        $existingUser = User::where('nric',"S9812381D")->first();

        if($existingUser){
            auth()->login($existingUser, true);
            return redirect()->to('/home');
        }else{
            $data = static::newuser($request, $response);
        }
        return redirect()->to('/');
    }
    public function jwks(){
        $key['keys'] =[array(
            "kty"=> "EC",
//            "d": "rTMBv7X9HgJfRjZCqyv6XQbOOk-G5C85tIRssTPnhLM",
            "use"=> "sig",
            "crv"=> "P-256",
            "kid"=> "idx-sig",
            "x"=> "vZU7a9zvPgDW0foGqkxtcbzYw796G1uYKLYCj0BGQYo",
            "y"=> "ocA9DH32SmIVzuObjeOMHvZZYuLrD4p66w4KE2gngSU",
            "alg"=> "ES256"
        ),array(
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
