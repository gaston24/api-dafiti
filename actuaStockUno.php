<?php

include __DIR__."/class/novedades.php";
include __DIR__."/post/products.php";

$novedad = new Novedad();
$list = $novedad->stock();
// $list = $novedad->stockPrueba();


$products = new Product();
// $response = $products->updateStockList([['XV9SLC08C0801', 95]]);
$response = $products->updateStockList($list);


// $novedad->stockDelete();



