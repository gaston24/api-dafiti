<?php

date_default_timezone_set("America/Argentina/Buenos_Aires");

$now = new DateTime();


function timestampParam($timestamp){
    //$objDateTime = new DateTime('NOW');
    $objDateTime = new DateTime($timestamp);
    $timestamp1 = (string) $objDateTime->format('c');
    $timestamp2 = substr($timestamp1, 0, 13).str_replace("+", "-03%3A", str_replace(":", "%3A", substr($timestamp1, 13, 9)));//.'%3A'.substr($timestamp1, 23, 2);

    return $timestamp2;
}

function timestamp(){
    $objDateTime = new DateTime('NOW');
    // $objDateTime = new DateTime($timestamp);
    $timestamp1 = (string) $objDateTime->format('c');
    $timestamp2 = substr($timestamp1, 0, 13).str_replace("+", "-03%3A", str_replace(":", "%3A", substr($timestamp1, 13, 9))).'%3A'.substr($timestamp1, 23, 2);

    return $timestamp2;
}

function timestampPuro(){
    $objDateTime = new DateTime('NOW');
    // $objDateTime = new DateTime($timestamp);
    $timestamp1 = $objDateTime->format('c');
    // $timestamp2 = substr($timestamp1, 0, 13).str_replace("+", "-03%3A", str_replace(":", "%3A", substr($timestamp1, 13, 9))).'%3A'.substr($timestamp1, 23, 2);

    return $timestamp1;
}


echo '---------------CON LOS REPLACE-------------------';
echo '<br>Api dafiti:<br>';
echo '2020-07-22T09%3A57%3A41-03%3A00';
//////////////ESTE ANDA///////////////////////
echo '<hr>Sin parametros:<br>';
echo timestamp();

echo '<hr>Con parametros estaticos:<br>';
echo timestampParam('2020-07-21T16:48:00+00:00');
echo '<hr>';
echo '---------------DE UNA-------------------<br>';
echo '2020-07-21T16:48:00+00:00'.'<br>';
echo timestampPuro().'<br>';



$parameters = array(
    'UserID' => 'sistemas@xl.com.ar',
    'Version' => '1.0',
    'Action' => 'GetOrder',
    'Format' => 'JSON',
    'Timestamp' => timestampPuro()
);

ksort($parameters);

$encoded = array();
foreach ($parameters as $name => $value) {
    $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
}

$concatenated = implode('&', $encoded);

$api_key = '0b336be5f661394f454789e9228c4d97dead5713';
$parameters['Signature'] = rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));

// echo $parameters['Signature'];
echo $parameters['Timestamp'].'<hr>';




$signature = $parameters['Signature'];
$timestamp = $parameters['Timestamp'];


$time = timestamp();


echo '<hr>Aca<br>';
echo $time;
echo '<hr>';
echo 'Formato: <br>';
echo '2020-07-21T16%3A29%3A52-03%3A00';

echo '<hr>';
echo $time;


///REQUEST

if(1==1){
    
echo '<hr>';
    
    
$curl = curl_init();

$orderID = '1454540';

// $url = 'https://rocket:rock4me@sellercenter-staging-api.dafiti.com.ar?Action=GetProducts&Filter=all&Format=JSON&Timestamp='.$time.'&UserID=sistemas%40xl.com.ar&Version=1.0&Signature='.$signature;
$url = 'https://rocket:rock4me@sellercenter-staging-api.dafiti.com.ar?Action=GetOrder&Format=JSON&OrderId='.$orderID.'&Timestamp='.$time.'&UserID=sistemas%40xl.com.ar&Version=1.0&Signature='.$signature;

echo $url.'<br>';
// echo 'https://rocket:rock4me@sellercenter-staging-api.dafiti.com.ar?Action=GetOrder&Format=JSON&OrderId=1454540&Timestamp=2020-07-22T10%3A19%3A39-03%3A00&UserID=sistemas%40xl.com.ar&Version=1.0&Signature=376b626c165b9d4bce067daef3e63bc30e02a470058bf7d40a6a5ec783ed4999';

// return;

echo '<hr>';

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",

));

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true);

var_dump($data);


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

}


