<?php



class Novedad
{

    public function stock(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SELECT TOP 50 A.COD_ARTICU, CAST(B.CANT_STOCK AS INT) CANT_STOCK FROM SJ_DAFITI_NOVEDAD_SALDO__STOCK A
        INNER JOIN STA19 B
        ON A.COD_ARTICU COLLATE Latin1_General_BIN = B.COD_ARTICU
        WHERE B.COD_DEPOSI = '12'
        ";
        $stmt = sqlsrv_query( $cid_central, $sql );

        $rows = array();

        while( $v = sqlsrv_fetch_array( $stmt) ) {
            $rows[] = $v;
        }

        return $rows;
    }

    public function stockDelete(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        delete top (50) from SJ_DAFITI_NOVEDAD_SALDO__STOCK
        ";
        $stmt = sqlsrv_query( $cid_central, $sql );

        sqlsrv_execute($stmt);
        
    }

    public function precios(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SELECT TOP 50 A.COD_ARTICU, cast(B.PRECIO as decimal(10, 2)) PRECIO  FROM SJ_DAFITI_NOVEDAD_PRECIO_VENTA A
        INNER JOIN GVA17 B
        ON A.COD_ARTICU COLLATE Latin1_General_BIN = B.COD_ARTICU AND A.NRO_DE_LIS = B.NRO_DE_LIS
        ";
        $stmt = sqlsrv_query( $cid_central, $sql );

        $rows = array();

        while( $v = sqlsrv_fetch_array( $stmt) ) {
            $rows[] = $v;
        }

        return $rows;
    }

    public function preciosDelete(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        delete top (50) from SJ_DAFITI_NOVEDAD_PRECIO_VENTA
        ";
        $stmt = sqlsrv_query( $cid_central, $sql );

        sqlsrv_execute($stmt);
        
    }

}