<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWK;
use Illuminate\Http\Request;
use Jose\Factory\JWKFactory;
use Jose\Loader;

class JWEController extends Controller
{

    public static function private_get_jwks_ec_local()
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,urlecProd);

        $response =curl_exec($ch);

        curl_close($ch);

        $jwks_uri = json_decode($response);

        $response = json_decode(json_encode($jwks_uri->keys[0]), true);

        return $response;
    }

    public static function private_key_jwe(Request $request)
    {
//        $jwk = new JWK([
//            "kty"=> "EC",
//            "d"=> "7FaRgw1cJmzGA1hss0YcLK4483zkKJ6JPafOwEoMlIw",
//            "use"=> "enc",
//            "crv"=> "P-256",
//            "kid"=> "idx-enc",
//            "x"=> "9Is-VbNwtijojiwRxWAbXxg-UTndznGFISU0RlQpfoY",
//            "y"=> "t67FS3cT-sohO_x5qsBvAnM5HTNkk_wNQza32YJg-6A",
//            "alg"=> "ECDH-ES+A128KW"
//        ]);
        $jwks_uri_ec_local = static::private_get_jwks_ec_local();

        $jwk = JWKFactory::createFromValues($jwks_uri_ec_local);

        $recipient_index=[];

        $loader = new Loader();
        // This is the input we want to load verify.
        // The payload is decrypted using our key.
        $jwe = $loader->loadAndDecryptUsingKey(
            $request->code,            // The input to load and decrypt
            $jwk,                 // The symmetric or private key
            ['ECDH-ES+A128KW'],      // A list of allowed key encryption algorithms
            ['A256CBC-HS512'],       // A list of allowed content encryption algorithms
            $recipient_index   // If decrypted, this variable will be set with the recipient index used to decrypt
        );
        $jwe = (array) $jwe;
        $data =$jwe["\x00Jose\Object\JWE\x00payload"];

        return $data;
    }
}
