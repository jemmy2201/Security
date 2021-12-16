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
        // $response = 'eyJhbGciOiJSU0EtT0FFUCIsImtpZCI6InNhbXdpc2UuZ2FtZ2VlQGhvYmJpdG9uLmV4YW1wbGUiLCJlbmMiOiJBMjU2R0NNIn0.rT99rwrBTbTI7IJM8fU3Eli7226HEB7IchCxNuh7lCiud48LxeolRdtFF4nzQibeYOl5S_PJsAXZwSXtDePz9hk-BbtsTBqC2UsPOdwjC9NhNupNNu9uHIVftDyucvI6hvALeZ6OGnhNV4v1zx2k7O1D89mAzfw-_kT3tkuorpDU-CpBENfIHX1Q58-Aad3FzMuo3Fn9buEP2yXakLXYa15BUXQsupM4A1GD4_H4Bd7V3u9h8Gkg8BpxKdUV9ScfJQTcYm6eJEBz3aSwIaK4T3-dwWpuBOhROQXBosJzS1asnuHtVMt2pKIIfux5BC6huIvmY7kzV7W7aIUrpYm_3H4zYvyMeq5pGqFmW2k8zpO878TRlZx7pZfPYDSXZyS0CfKKkMozT_qiCwZTSz4duYnt8hS4Z9sGthXn9uDqd6wycMagnQfOTs_lycTWmY-aqWVDKhjYNRf03NiwRtb5BE-tOdFwCASQj3uuAgPGrO2AWBe38UjQb0lvXn1SpyvYZ3WFc7WOJYaTa7A8DRn6MC6T-xDmMuxC0G7S2rscw5lQQU06MvZTlFOt0UvfuKBa03cxA_nIBIhLMjY2kOTxQMmpDPTr6Cbo8aKaOnx6ASE5Jx9paBpnNmOOKH35j_QlrQhDWUN6A2Gg8iFayJ69xDEdHAVCGRzN3woEI2ozDRs.-nBoKLH0YkLZPSI9.o4k2cnGN8rSSw3IDo1YuySkqeS_t2m1GXklSgqBdpACm6UJuJowOHC5ytjqYgRL-I-soPlwqMUf4UgRWWeaOGNw6vGW-xyM01lTYxrXfVzIIaRdhYtEMRBvBWbEwP7ua1DRfvaOjgZv6Ifa3brcAM64d8p5lhhNcizPersuhw5f-pGYzseva-TUaL8iWnctc-sSwy7SQmRkfhDjwbz0fz6kFovEgj64X1I5s7E6GLp5fnbYGLa1QUiML7Cc2GxgvI7zqWo0YIEc7aCflLG1-8BboVWFdZKLK9vNoycrYHumwzKluLWEbSVmaPpOslY2n525DxDfWaVFUfKQxMF56vn4B9QMpWAbnypNimbM8zVOw.UCGiqJxhBI3IFVdPalHHvA';
        // The payload is decrypted using our key.
        $jwe = $loader->loadAndDecryptUsingKey(
            $request->code,            // The input to load and decrypt
            $jwk,                 // The symmetric or private key
            ['ECDH-ES+A128KW'],      // A list of allowed key encryption algorithms
            ['A256CBC-HS512'],       // A list of allowed content encryption algorithms
            $recipient_index   // If decrypted, this variable will be set with the recipient index used to decrypt
        );
        $jwe = (array) $jwe;

        return $jwe;
    }
}
