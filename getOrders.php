<?php

include __DIR__."/get/orders.php";
include __DIR__."/class/pedido.php";


$orders = new Order();
$list = $orders->getOrders();
$row = 1;

$pedidos = new Pedido();
$listPedidosExistentes = $pedidos->traerPedidos();

$pedidosExistentes = [];
foreach ($listPedidosExistentes as $key => $value) {
    array_push($pedidosExistentes, $value['NRO_ORDEN_ECOMMERCE']);
}


use \DateTime as DT;

/* ESTADO DEL DESARROLLO */
/* 0 = DEBBUGEA */
/* 1 = EJECUTA */
$estado = 1;


// ENCABEZADO
$orderItems = [];
foreach ($list as $key => $value) {
    foreach($value['Body'] as $body => $value){
        foreach($value['Order'] as $body => $value){
            if(!in_array($value['OrderNumber'], $pedidosExistentes)){
                
                array_push($orderItems, $value['OrderId']);

                $orderId = $value['OrderId'];
                $orderNumber = $value['OrderNumber'];
                $fechaCreate = strtotime($value['CreatedAt']);

                $cantArt = $value['ItemsCount'];
                $price = $value['Price'];

                if($estado == 0 ){
                    echo $orderId.' '.$orderNumber.' '.date('Y-m-d H:i:s', $fechaCreate).' '.$cantArt.' '.$price.'<br>';
                }elseif($estado == 1){
                    $pedidos->insertarEncabezado($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $cantArt, $price);
                    // echo $orderId.' '.$orderNumber.' '.date('Y-m-d H:i:s', $fechaCreate).' '.$cantArt.' '.$price.'<br>';
                }

                

                // CLIENTE

                $firstName = $value['CustomerFirstName'];
                $lastName = $value['CustomerLastName'];
                $telefono1 = $value['AddressBilling']['Phone'];
                $telefono2 = $value['AddressBilling']['Phone2'];
                $direccion1 = $value['AddressBilling']['Address1'];
                $direccion2 = $value['AddressBilling']['Address2'];
                $ciudad = $value['AddressBilling']['City'];
                $cPostal = $value['AddressBilling']['PostCode'];
                $eMail = $value['AddressBilling']['CustomerEmail'];
                $dni = $value['NationalRegistrationNumber'];
                if($estado == 0 ){
                    echo $firstName.' '.$lastName.' '.$telefono1.' '.$telefono2.' '.$direccion1.' '.$direccion2.' '.$ciudad.' '.$cPostal
                    .' '.$eMail.' '.$dni.'<br>';
                    echo '<hr>';
                }elseif($estado == 1){
                    $pedidos->insertarCliente($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $firstName, $lastName, $telefono1, $telefono2, $direccion1, $direccion2, $ciudad, $cPostal, $eMail, $dni);
                }
            }
        }
    }
}
// array_push($orderItems, 2543024);

$orderItems = '['.implode(', ',$orderItems).']';

// echo 'entre';

// DETALLE
$orderDetails = $orders->getMultipleOrdersItems($orderItems);

// print_r($orderItems);

echo '<hr>';

if($estado == 1 ){
    foreach ($orderDetails as $key => $value1) {

        foreach($value1['Body'] as $body => $value2){

            if(isset($value2['Order'])){
                // echo 'entre 1';
                foreach($value2 as $body => $value3['Order']){

                    // echo 'foreach';

                    // var_dump($value3['Order']);
                    // return;

                    if(isset($value3['Order']['OrderId'])){

                        echo 'esta seteado';

                        $orderId = $value3['Order']['OrderId'];
        
                        $orderNumber = $value3['Order']['OrderNumber'];
                        
                        $nroArt= 1;

                        foreach ($value3['Order']['OrderItems'] as $key => $value4) {
        
                            echo 'entre raro';
            
                            if(isset($value4['Sku'])){
        
                                echo 'if si';
                                
                                $fechaCreate = strtotime($value4['CreatedAt']);
                                
                                $codArticu = $value4['Sku'];
                                $precioArt = $value4['PaidPrice'];
                                
                                
                                if($estado==0){
                                    echo $fechaCreate.' '.$codArticu.' '.$precioArt.'<br>';
                                }elseif ($estado == 1) {
                                    $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                                }
                                
                                
                            }else{
                                echo 'if no';
                                foreach ($value4 as $key2 ) {
                                    if (is_array($key2)){
                    
                                        $fechaCreate = strtotime($key2['CreatedAt']);     
                                        $codArticu = $key2['Sku'];
                                        $precioArt = $key2['PaidPrice'];
            
                                        if($estado==0){
                                            echo $fechaCreate.' '.$codArticu.' '.$precioArt.'<br>';
                                        }elseif ($estado == 1) {
                                            $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                                        }
        
                                        $nroArt++;
                                    }
                                }
                            }
            
                        }

                    }else{

                        foreach($value2 as $key => $value3){
                
                            $nroArt= 1;
                            
                            foreach ($value3 as $key => $value4) {
                                
                                $orderId = $value4['OrderId'];
                                $orderNumber = $value4['OrderNumber'];
                
                                echo $orderId.' '.$orderNumber.'<br>';
                
                                if (isset($value4['OrderItems'])){
                                    foreach ($value4['OrderItems'] as $key => $value5) {
                                        
                                        if(isset($value5['CreatedAt'])){

                                            $fechaCreate = strtotime($value5['CreatedAt']);     
                                            $codArticu = $value5['Sku'];
                                            $precioArt = $value5['PaidPrice'];
                    
                                            if($estado==0){
                                                echo $fechaCreate.' '.$codArticu.' '.$precioArt.'<br>';
                                            }elseif ($estado == 1) {
                                                $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                                            }

                                        }else{
                                            foreach($value5 as $key){
                                                // print_r($key);
                                                $fechaCreate = strtotime($key['CreatedAt']);     
                                                $codArticu = $key['Sku'];
                                                $precioArt = $key['PaidPrice'];

                                                if($estado==0){
                                                    echo $fechaCreate.' '.$codArticu.' '.$precioArt.'<br>';
                                                }elseif ($estado == 1) {
                                                    $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                                                }
                                            }
                                        }

                                        
                                    }
                                }else{
                                    echo 'no esta seteado';
                                }
                
                                $nroArt++;
                                
                                
                                echo '<hr><hr>';
                
                            }
                
                        }

                    }
        
                    

        
                }
            }else{
                echo 'entre 2';
                foreach($value2 as $key => $value3){
                
                    $nroArt= 1;
                    
                    foreach ($value3 as $key => $value4) {
                        
                        $orderId = $value4['OrderId'];
                        $orderNumber = $value4['OrderNumber'];
        
                        echo $orderId.' '.$orderNumber.'<br>';
        
                        if (isset($value4['OrderItems'])){
                            foreach ($value4['OrderItems'] as $key => $value5) {
                                $fechaCreate = strtotime($value5['CreatedAt']);     
                                $codArticu = $value5['Sku'];
                                $precioArt = $value5['PaidPrice'];
        
                                if($estado==0){
                                    echo $fechaCreate.' '.$codArticu.' '.$precioArt.'<br>';
                                }elseif ($estado == 1) {
                                    $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                                }
                            }
                        }else{
                            echo 'no esta seteado';
                        }
        
                        $nroArt++;
                        
                        
                        echo '<hr><hr>';
        
                    }
        
                }
            }
            

            
        }
    }
}