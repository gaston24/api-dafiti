<?php

include __DIR__."/post/products.php";
include __DIR__."/class/novedades.php";

$novedad = new Novedad();
$list = $novedad->stock();

$products = new Product();
$response = $products->updateStockList($list);

$novedad->stockDelete();



