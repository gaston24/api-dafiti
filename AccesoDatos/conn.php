<?php

try {

    $servidor_central = 'servidor';
    $conexion_central = array( "Database"=>"LAKER_SA", "UID"=>"sa", "PWD"=>"Axoft1988");
    $array_central = array("SERVIDOR"=>"servidor", "Database"=>"LAKER_SA", "UID"=>"sa", "PWD"=>"Axoft1988");
    $cid_central = sqlsrv_connect($servidor_central, $conexion_central);
    
} catch (PDOException $e){
        echo $e->getMessage();
}

