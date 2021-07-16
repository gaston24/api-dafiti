<?php

include __DIR__."/../AccesoDatos/credenciales.php";

class Order {

    function getOrders(){
        date_default_timezone_set("UTC");

        // set current date less 15 days (field CreatedAfter)
        $now = new DateTime();
        $fecha = $now->format(DateTime::ISO8601);
        // echo date_create($fecha)->modify('-15 days')->format('Y-m-d');

        $parameters = array(
        'UserID' => user,
        // 'CreatedAfter' => '2021-07-10',
        'CreatedAfter' => date_create($fecha)->modify('-15 days')->format('Y-m-d'),
        // 'Limit' => $cant,
        'Version' => '1.0',
        'Action' => 'GetOrders',
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

    function getOrderItems($order){
        date_default_timezone_set("UTC");

        // set current date less 15 days (field CreatedAfter)
        $now = new DateTime();
        $fecha = $now->format(DateTime::ISO8601);
        // echo date_create($fecha)->modify('-15 days')->format('Y-m-d');

        $parameters = array(
        'UserID' => user,
        // 'CreatedAfter' => '2021-07-10',
        'CreatedAfter' => date_create($fecha)->modify('-15 days')->format('Y-m-d'),
        'OrderId' => $order,
        'Version' => '1.0',
        'Action' => 'GetOrderItems',
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

    function getMultipleOrdersItems($list){
        date_default_timezone_set("UTC");

        $now = new DateTime();

        $parameters = array(
        'UserID' => user,
        'CreatedAfter' => '2021-04-20',
        'OrderIdList' => $list,
        'Version' => '1.0',
        'Action' => 'GetMultipleOrderItems',
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


