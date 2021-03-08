<?php
include __DIR__."/../AccesoDatos/credenciales.php";

class Product {

    function getProducts($product, $cant){
        date_default_timezone_set("UTC");

        $now = new DateTime();

        $parameters = array(
        'UserID' => user,
        'Search' => $product,
        'Limit' => $cant,
        'Version' => '1.0',
        'Action' => 'GetProducts',
        'Format' => 'JSON',
        'Timestamp' => $now->format(DateTime::ISO8601)
        );

        ksort($parameters);

        $encoded = array();
        foreach ($parameters as $name => $value) {
        $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
        }

        $concatenated = implode('&', $encoded);

        $api_key = apiKey;
        $parameters['Signature'] = rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));
        $url = url;

        $queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url."?".$queryString);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);


        return $data;


    }

}


