<?php

// require_once 'get/products.php';

include __DIR__."/get/products.php";

$sku = $_GET['sku'];


$products = new Product();
$list = $products->getProducts($sku.'%', '5000');
$row = 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

</head>
<body>



<table class="table table-hover table-sm">
<thead>
    <th>SellerSku </th>
    <th>Name </th>
    <th>Variation </th>
    <th>SellerSku</th>
    <th>Quantity </th>
    <th>Available </th>
    <th>Price </th>
    <th>SalePrice </th>
</thead>
<tbody>
<?php
foreach ($list as $key => $value) {
    foreach($value['Body'] as $body => $value){
        foreach($value['Product'] as $product => $value){
            echo '<tr>';
            echo '<td>'.$value['SellerSku'].'</td>';
            echo '<td>'.$value['Name'].'</td>';
            echo '<td>'.$value['Variation'].'</td>';
            echo '<td>'.$value['SellerSku'].'</td>';
            echo '<td>'.$value['Quantity'].'</td>';
            echo '<td>'.$value['Available'].'</td>';
            echo '<td>'.$value['Price'].'</td>';
            echo '<td>'.$value['SalePrice'].'</td>';
            echo '</tr>';
        }
        $row++;
    }
}
?>
</tbody>

</table>



<script src="assets/bootstrap/jquery-3.5.1.slim.min.js"></script>
<script src="assets/bootstrap/popper.min.js" ></script>
<script src="assets/bootstrap/bootstrap.min.js" ></script>
    
</body>
</html>



