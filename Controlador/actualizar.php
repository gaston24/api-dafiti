<?php

include_once '../class/products.php';


$producto = new Producto();


$codArticu = $_POST['codArticu'];

$producto->enviarNovedad($codArticu);

echo $codArticu.' - Articulo enviado';

