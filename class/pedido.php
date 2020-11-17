<?php

class Pedido{

    public function traerPedidos(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SET DATEFORMAT YMD

        SELECT DISTINCT NRO_ORDEN_ECOMMERCE
        FROM SOF_AUDITORIA 
        WHERE ORIGEN LIKE 'DA%'
        AND FECHA_PEDIDO >= '2020-11-11'
        ";

        $sql2 = "
        SELECT DISTINCT ORDER_NUMBER NRO_ORDEN_ECOMMERCE FROM SJ_DAFITI_API_ENCABEZADO
        ";

        $stmt = sqlsrv_query( $cid_central, $sql );

        $rows = array();

        while( $v = sqlsrv_fetch_array( $stmt) ) {
            $rows[] = $v;
        }

        return $rows;
    }


    public function insertarEncabezado($orderId, $orderNumber, $fechaCreate, $cantArt, $price){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SET DATEFORMAT YMD

        EXEC SJ_DAFITI_API_INSERT_ENCABEZADO $orderId, $orderNumber, '$fechaCreate', $cantArt, $price

        ";
        $stmt = sqlsrv_prepare( $cid_central, $sql );

        sqlsrv_execute($stmt);
    }


    public function insertarDetalle($orderId, $orderNumber, $fechaCreate, $nroArt, $codArticu, $precioArt){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SET DATEFORMAT YMD

        EXEC SJ_DAFITI_API_INSERT_DETALLE $orderId, $orderNumber, '$fechaCreate', $nroArt, '$codArticu', $precioArt

        ";
        $stmt = sqlsrv_prepare( $cid_central, $sql );

        sqlsrv_execute($stmt);
    }


    public function insertarCliente($orderId, $orderNumber, $fechaCreate, $firstName, $lastName, $telefono1, $telefono2, $direccion1, $direccion2, $ciudad, $cPostal, $eMail, $dni){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SET DATEFORMAT YMD

        EXEC SJ_DAFITI_API_INSERT_CLIENTE 
        $orderId, $orderNumber, '$fechaCreate', '$firstName', '$lastName', '$telefono1', '$telefono2', '$direccion1', '$direccion2', '$ciudad', '$cPostal', '$eMail', '$dni'
        ";
        $stmt = sqlsrv_prepare( $cid_central, $sql );

        sqlsrv_execute($stmt);
    }








}