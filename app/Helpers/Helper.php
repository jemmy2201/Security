<?php
use Firebase\JWT\JWT;

if (!function_exists('secret_encode')) {
    /**
     * Group array of : key => Group Title
     * @param array $exclude
     * @return array
     */
    function secret_encode($nric)
    {
        $key= file_get_contents('PrivateKey.pem');

        $payload = array(
            "iss" => $nric,
            "aud" => "https://www.idx-id2021.com",
        );

        $jwt = JWT::encode($payload, $key, 'HS256');
        return  $jwt;
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
        $key= file_get_contents('PrivateKey.pem');

        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $decoded_array = (array) $decoded;
        return  $decoded_array['iss'];
    }
}
