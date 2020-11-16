<?php

require_once 'post/products.php';
include 'class/novedades.php';

$novedad = new Novedad();
$list = $novedad->precios();
// $list = $novedad->stock();

// $list =  array(
//     ['XJKE08-978-07M', 2690]
// );

$products = new Product();
$response = $products->updatePriceList($list);
$novedad->preciosDelete();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Precios Articulos</title>

    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

</head>
<body>

<?php
foreach($list as $precio){
    echo $precio[0].' '.$precio[1].'<br>';
}
echo '<hr>';

var_dump($response);

?>

<script src="assets/bootstrap/jquery-3.5.1.slim.min.js"></script>
<script src="assets/bootstrap/popper.min.js" ></script>
<script src="assets/bootstrap/bootstrap.min.js" ></script>
    
</body>
</html>



