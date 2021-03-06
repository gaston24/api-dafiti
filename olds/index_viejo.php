<?php

// Pay no attention to this statement.
// It's only needed if timezone in php.ini is not set correctly.
date_default_timezone_set("UTC");

// The current time. Needed to create the Timestamp parameter below.
$now = new DateTime();

// The parameters for our GET request. These will get signed.
$parameters = array(
    // The user ID for which we are making the call.
    'UserID' => 'sistemas@xl.com.ar',

    'OrderId'=> '1352988',
    
    // 'GetProducts'=> '1352988',

    'Search' => 'XJKE08-979',

    'Limit' => '10',

    // The API version. Currently must be 1.0
    'Version' => '1.0',

    // The API method to call.
    'Action' => 'GetProducts',

    // The format of the result.
    'Format' => 'JSON',

    // The current time formatted as ISO8601
    'Timestamp' => $now->format(DateTime::ISO8601)
);

// Sort parameters by name.
ksort($parameters);

// URL encode the parameters.
$encoded = array();
foreach ($parameters as $name => $value) {
    $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
}

// Concatenate the sorted and URL encoded parameters into a string.
$concatenated = implode('&', $encoded);

// The API key for the user as generated in the Seller Center GUI.
// Must be an API key associated with the UserID parameter.
$api_key = '0b336be5f661394f454789e9228c4d97dead5713';

// Compute signature and add it to the parameters.
$parameters['Signature'] =
    rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));

    // ...continued from above

// Replace with the URL of your API host.
$url = "https://rocket:rock4me@sellercenter-staging-api.dafiti.com.ar";

// Build Query String
$queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);

// Open cURL connection
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url."?".$queryString);

// Save response to the variable $data
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


$response = curl_exec($ch);

// Close Curl connection
curl_close($ch);

$data = json_decode($response, true);

print_r($data);

// foreach($data as $dato => $value){
//     foreach($value['Body'] as $body => $value){
//         foreach($value['Order'] as $body => $value){
//             @array_walk_recursive($value, function($item, $clave){
//                 if($clave!=''){
//                     echo $clave.' - '.$item.'<br>';
//                 }
//             });
//         }
//     }
// }




// [Quantity] => 890
// [Available] => 890
// [Price] => 1690.00


