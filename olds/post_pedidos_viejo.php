foreach ($orderDetails as $key => $value1) {
    foreach($value1['Body'] as $body => $value2){
        foreach($value2 as $body => $value3['Order']){

            // var_dump($value3['Order']);

            $orderId = $value3['Order']['OrderId'];
            $orderNumber = $value3['Order']['OrderNumber'];
            
            $nroArt= 1;
            
            foreach ($value3['Order']['OrderItems'] as $key => $value4) {

                // echo 'entre';

                if(isset($value4['Sku'])){

                    $fechaCreate = strtotime($value4['CreatedAt']);
                    
                    $codArticu = $value4['Sku'];
                    $precioArt = $value4['PaidPrice'];

                    
                    echo $fechaCreate.' '.$codArticu.' '.$precioArt.'aaa<br>';
                    echo '<hr>';
                    // // var_dump($value4);
                    // echo '<hr>';

                    // $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                }else{
                    foreach ($value4 as $key2 ) {
                        if (is_array($key2)){
        
                            $fechaCreate = strtotime($key2['CreatedAt']);     
                            $codArticu = $key2['Sku'];
                            $precioArt = $key2['PaidPrice'];

                            echo $fechaCreate.' '.$codArticu.' '.$precioArt.'aca<br>';
                            // var_dump($key2);
                            echo '<hr>';

                            // $pedidos->insertarDetalle($orderId, $orderNumber, date('Y-m-d H:i:s', $fechaCreate), $nroArt, $codArticu, $precioArt);
                            $nroArt++;
                        }
                    }
                }

            }

        }
    }
}
