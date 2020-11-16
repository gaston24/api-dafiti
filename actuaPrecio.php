<?php

include __DIR__."/post/products.php";
include __DIR__."/class/novedades.php";

$novedad = new Novedad();
$list = $novedad->precios();

$products = new Product();
$response = $products->updatePriceList($list);

$novedad->preciosDelete();



