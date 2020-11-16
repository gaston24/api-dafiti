<?php

include __DIR__."/../AccesoDatos/credenciales.php";

class Product{

    function updatePrice($sku, $price){

        date_default_timezone_set("UTC");

        $now = new DateTime();

        $parameters = array(
        'UserID' => user,
        'Version' => '1.0',
        'Action' => 'ProductUpdate',
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

        curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n<Request>\r\n<Product>\r\n<SellerSku>$sku</SellerSku>\r\n<Price>$price</Price>\r\n<SalePrice></SalePrice>\r\n<SaleStartDate></SaleStartDate>\r\n<SaleEndDate></SaleEndDate>\r\n</Product>\r\n</Request>",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml"
        ),
        ));

        $response = curl_exec($ch);

        curl_close($ch);
        echo $sku.'->'.$price.'->'.$response.'<br>';

    }

    function updateStock($sku, $stock){

        date_default_timezone_set("UTC");

        $now = new DateTime();

        $parameters = array(
        'UserID' => user,
        'Version' => '1.0',
        'Action' => 'ProductUpdate',
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

        curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n<Request>\r\n<Product>\r\n<SellerSku>$sku</SellerSku>\r\n<Quantity>$stock</Quantity>\r\n</Product>\r\n</Request>",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml"
        ),
        ));

        $response = curl_exec($ch);

        curl_close($ch);
        echo $sku.'->'.$stock.'->'.$response.'<br>';

    }


    function updatePriceList($listaPrueba){

        $array = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n<Request>\r\n";

        foreach($listaPrueba as $key => $value){
            $sku = $value[0];
            $price = $value[1];
            $array .= "<Product>\r\n<SellerSku>$sku</SellerSku>\r\n<Price>$price</Price>\r\n<SalePrice></SalePrice>\r\n<SaleStartDate></SaleStartDate>\r\n<SaleEndDate></SaleEndDate>\r\n</Product>\r\n";
        }

        $array .= "</Request>";

        date_default_timezone_set("UTC");

        $now = new DateTime();

        $parameters = array(
        'UserID' => user,
        'Version' => '1.0',
        'Action' => 'ProductUpdate',
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

        curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$array,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml"
        ),
        ));

        $response = curl_exec($ch);

        curl_close($ch);
        return $response;

    }

    function updateStockList($listaPrueba){

        $array = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n<Request>\r\n";

        foreach($listaPrueba as $key => $value){
            $sku = $value[0];
            $stock = $value[1];
            $array .= "<Product>\r\n<SellerSku>$sku</SellerSku>\r\n<Quantity>$stock</Quantity>\r\n</Product>\r\n";
        }

        $array .= "</Request>";

        date_default_timezone_set("UTC");

        $now = new DateTime();

        $parameters = array(
        'UserID' => user,
        'Version' => '1.0',
        'Action' => 'ProductUpdate',
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

        curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$array,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml"
        ),
        ));

        $response = curl_exec($ch);

        curl_close($ch);
        return $response;

    }
   
}