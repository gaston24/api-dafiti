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
    

}