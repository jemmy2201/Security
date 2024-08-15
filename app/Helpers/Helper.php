<?php
use Firebase\JWT\JWT;
if (!function_exists('detect_url')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function detect_url()
    {

        $reponse = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        return $reponse;
    }
}
if (!function_exists('encrypt_decrypt')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function encrypt_decrypt($string, $action = 'encrypt')
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = env('SECRET_NRIC'); // user define private key
        $secret_iv = env('SECRET_NRIC_IV'); // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
}
if (!function_exists('search_nric_private')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function search_nric_private($nric)
    {
        $a=array("a"=>"","b"=>"S1718365F","c"=>"S7278599A","d"=>"S1354898F","e"=>"S3002114B");

        return array_search($nric,$a);
    }

}

if (!function_exists('GetNonce')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function GetNonce()
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}

if (!function_exists('GetState')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function GetState()
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}

if (!function_exists('secret_encode')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function secret_encode($nric)
    {
//        $key= file_get_contents('PrivateKey.pem');
//
//        $payload = array(
//            "iss" => $nric,
//            "aud" => "https://www.idx-id2021.com",
//        );
//
//        $jwt = JWT::encode($payload, $key, 'HS256');
//        return  $jwt;

        return encrypt_decrypt($nric, 'encrypt');
    }

}

if (!function_exists('secret_decode')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function secret_decode($jwt)
    {
//        $key= file_get_contents('PrivateKey.pem');
//
//        $decoded = JWT::decode($jwt, $key, array('HS256'));
//        $decoded_array = (array) $decoded;
//        return  $decoded_array['iss'];

        return encrypt_decrypt($jwt, 'decrypt');

    }
}
