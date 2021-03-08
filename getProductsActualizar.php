<?php

include __DIR__."/get/products.php";
include __DIR__."/class/products.php";

// $sku = $_GET['sku'];


$products = new Product();
$list = $products->getProducts('X%', '5000');
$row = 1;

$producto = new Producto();
$producto->borrarArt();


foreach ($list as $key => $value) {
    foreach($value['Body'] as $body => $value) {
        foreach($value['Product'] as $product => $value) {
            $producto->insertArt($value['SellerSku'], $value['Available'], $value['Price']);
        }
    }
}

header("Location: getProductsBase.php");



