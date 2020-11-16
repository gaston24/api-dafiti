<?php 
include 'class/novedades.php';
include 'post/products.php';
$novedad = new Novedad();
$list = $novedad->stock();
// $list = $novedad->precios();

// $list =  array(
//     ['XJKE08-978-07M', 0]
// );

$updateProducts = new Product();
$updateProducts->updateStockList($list);
$novedad->stockDelete();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
foreach($list as $stock){
    echo $stock[0].' '.$stock[1].'<br>';
}
?>   

</body>
</html>