<?php

class Producto
{

    public function insertArt($codArt, $cant, $precio){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        INSERT INTO SJ_DAFITI_AUDITORIA_ARTICULOS (COD_ARTICU, STOCK, PRECIO, FECHA)
        VALUES ('$codArt', $cant, $precio, getdate())
        ";

        $stmt = sqlsrv_prepare( $cid_central, $sql );
        sqlsrv_execute($stmt);
    }

    public function borrarArt(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        TRUNCATE TABLE SJ_DAFITI_AUDITORIA_ARTICULOS
        ";

        $stmt = sqlsrv_prepare( $cid_central, $sql );
        sqlsrv_execute($stmt);
    }


    public function articulosAuditoria(){
        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        SELECT 
        A.*, C.STOCK_DISPONIBLE, D.PRECIO PRECIO_CENTRAL, 
        E.DESCRIPCIO,
        CASE WHEN (A.STOCK <> STOCK_DISPONIBLE) THEN 'DIF STOCK' 
        WHEN (A.PRECIO <> D.PRECIO) THEN 'DIF PRECIO' 
        ELSE 'OK' END ESTADO 
        FROM SJ_DAFITI_AUDITORIA_ARTICULOS A
        LEFT JOIN SJ_DAFITI_NOVEDAD_SALDO__STOCK B
        ON A.COD_ARTICU = B.COD_ARTICU COLLATE Latin1_General_BIN
        LEFT JOIN SJ_STOCK_DISPONIBLE_ECOMMERCE C
        ON A.COD_ARTICU COLLATE Latin1_General_BIN = C.COD_ARTICU
        LEFT JOIN GVA17 D
        ON A.COD_ARTICU = D.COD_ARTICU 
        LEFT JOIN STA11 E
        ON A.COD_ARTICU = E.COD_ARTICU

        WHERE C.COD_DEPOSI = '01'
        AND D.NRO_DE_LIS = 20
        ORDER BY COD_ARTICU
        ";

        $stmt = sqlsrv_query( $cid_central, $sql );

        $rows = array();

        while( $v = sqlsrv_fetch_array( $stmt) ) {
            $rows[] = $v;
        }

        return $rows;
    }

    public function enviarNovedad($codArt){

        include __DIR__."/../AccesoDatos/conn.php";
        $sql = "
        EXEC SJ_DAFITI_ENVIAR_NOVEDAD '$codArt'
        ";

        $stmt = sqlsrv_prepare( $cid_central, $sql );
        sqlsrv_execute($stmt);
    }

    

}