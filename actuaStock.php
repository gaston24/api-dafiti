<?php

include __DIR__."/class/novedades.php";
include __DIR__."/post/products.php";

$novedad = new Novedad();
$list = $novedad->stock();

// print_r ($list);

// return;

$products = new Product();
$response = $products->updateStockList($list);

$novedad->stockDelete();



