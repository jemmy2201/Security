<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
class SingpassController extends Controller
{
    protected function newuser($request,$response)
    {
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

    public function login(Request $request)
    {

//        $privateKey = <<<EOD
//-----BEGIN EC PRIVATE KEY-----
//MHcCAQEEILN6aQktL+2TAqwqSttDRD1xaAblpO6FG10w22F6Ky7loAoGCCqGSM49
//AwEHoUQDQgAE74g4ykDuo3dR/EG5j/yupcUSmcWVszq/dIBwzP9iet6hDqwXoKk9
//wLd5m8/RNnbhlLPWwn+3zIBabDupAhtRYA==
//-----END EC PRIVATE KEY-----
//EOD;
//
//            $Exp_encode   = Carbon::now()->addMinutes('2')->timestamp;
//            $Iat_encode   = Carbon::now()->timestamp;
//
//            $payload = array(
//                "sub" => clientIdSinpass,
//                "aud" => "https://stg-id.singpass.gov.sg",
//                "iss" => clientIdSinpass,
//                "iat" => $Iat_encode,
//                "exp" => $Exp_encode
//            );
//
//            $Data_payload = JWT::encode($payload, $privateKey,'ES256');
//            $jwt = $Data_payload ;
//            die($jwt);
        // get the local secret key

        $key = json_encode([
            "kty"=> "EC",
            "d"=> "AUWpVkN6AOZ195lPgATc8iBCOJajaiweEy3ChWsEhFaB9meM2OWZXqfu3634KwJjJ32UGS8vyfggptF_aKmglZHp",
            "use"=> "sig",
            "crv"=> "P-521",
            "kid"=> "idx",
            "x"=> "AC2dySQ5arD18Wf4baLejfogBJmirK5PKf7a20x9f27KDKZymLTn7T7iKCjpI4PmIHYJ85-psv1piDM5MOeiEgbB",
            "y"=> "APTgUPTb21D01DRmX_LIkmzrv5HEUL5IQMftxZAJ8cVGeCIKijdnvIymjxAT9BUeGNtHS0nm1_IJxyhpbaopz5zF",
            "alg"=> "ES512"
        ]);

        $Exp_encode   = Carbon::now()->addMinutes('2')->timestamp;
        $Iat_encode   = Carbon::now()->timestamp;
        // Create the token header
        $header = json_encode([
            "typ" => "JWT",
            "alg" => "ES256",
        ]);

        // Create the token payload
        $payload = json_encode([
            "sub" => clientIdSinpass,
            "aud" => "https://stg-id.singpass.gov.sg",
            "iss" => clientIdSinpass,
            "iat" => $Iat_encode,
            "exp" => $Exp_encode
        ]);
        // Encode Header
        $base64UrlHeader = $this->base64url_encode($header);

        // Encode Payload
        $base64UrlPayload = $this->base64url_encode($payload);

        // Encode Key
        $base64UrlKey = $this->base64url_encode($key);

        // Create Signature Hash
        $signature = hash_hmac("sha256", $base64UrlHeader . "." . $base64UrlPayload, $key);

        // Encode Signature to Base64Url String
        $base64UrlSignature = $this->base64url_encode($signature);

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        die($jwt);
        $data = [
            'client_assertion' => $jwt,
            'client_assertion_type' => "urn:ietf:params:oauth:client-assertion-type:jwt-bearer",
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

//        $key = 'enc';
//        $Exp_decode   = Carbon::now()->addMinutes('10')->timestamp;
//        $Iat_decode   = Carbon::now()->timestamp;
//        $payload = array(
//            "sub" => $response['id_token'],
//            "aud" => clientIdSinpass,
//            "amr" => [ "pwd", "swk" ],
//            "iss" => "https://stg-id.singpass.gov.sg",
//            "exp" => $Exp_decode,
//            "iat" => $Iat_decode,
//            "nonce" => "qnQcCZx9RF6nx4TjwQTSI2gOHZ7ie0jHSGUd0kd5iIU="
//        );
//
//        $decoded = JWT::decode($jwt, $key, array('HS256'));

        $existingUser = User::where('nric',"S9812381D")->first();
        if($existingUser){
            auth()->login($existingUser, true);
            return redirect()->to('/home');
        }else{
//            $data = $this->newuser($request, $response);
        }
        return redirect()->to('/');
    }
    public function jwks(){
        $key['keys'] =[array(
            "kty"=> "EC",
            "use"=> "sig",
            "crv"=> "P-521",
            "kid"=> "idx",
            "x"=> "AC2dySQ5arD18Wf4baLejfogBJmirK5PKf7a20x9f27KDKZymLTn7T7iKCjpI4PmIHYJ85-psv1piDM5MOeiEgbB",
            "y"=> "APTgUPTb21D01DRmX_LIkmzrv5HEUL5IQMftxZAJ8cVGeCIKijdnvIymjxAT9BUeGNtHS0nm1_IJxyhpbaopz5zF",
            "alg"=> "ES512"
            ),array(
            "kty"=> "EC",
            "use"=> "enc",
            "crv"=> "P-521",
            "kid"=> "idx-enc",
            "x"=> "AVqxiXGKBGyGexP-q_2LfDW0uFDCHCnJC55S0IMD3fhGEa__3aDp4wSPBI-6Gt1JhxFYRhzW7mxPZeajPmkpewVC",
            "y"=> "AfwzgYm2Ovad3pcjlbMOEBMSXFAAtJ9O7R02bw-BR3a7XCE0P_3w1GK4b7z4XEQSNjpa0LUuaNhuHYQTtIkhS8EJ",
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
