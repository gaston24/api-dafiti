<?php



require_once 'Class/novedades.php';

$novedad = new Novedad();

// $newStock = $novedad->stock();


foreach ($novedad->stock() as $key => $value) {
    // echo $value['COD_ARTICU'].'<br>';
    updateStock($value['COD_ARTICU'], $value['CANT_STOCK']);
    // updatePrecio($value, 444, 555);

}





