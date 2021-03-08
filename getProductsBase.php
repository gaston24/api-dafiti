<?php

include __DIR__."/class/products.php";

$producto = new Producto();


$listadoFinal = $producto->articulosAuditoria();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">

</head>
<body>



<table class="table table-hover table-sm">
<thead>

    <th>Nº </th>
    <th>COD ARTICU </th>
    <th>DESCRIPCION </th>
    <th>STOCK </th>
    <th>PRECIO </th>
    <th>STOCK DISP </th>
    <th>PRECIO CENTRAL </th>
    <th>ESTADO </th>
    <th>ACCION </th>
</thead>
<tbody>
<?php
foreach ($listadoFinal as $key => $value) {
    echo '<tr>';
    echo '<td>'.$value['ID'].'</td>';
    echo '<td>'.$value['COD_ARTICU'].'</td>';
    echo '<td>'.$value['DESCRIPCIO'].'</td>';
    echo '<td>'.number_format($value['STOCK'],0,",",".").'</td>';
    echo '<td>'.number_format($value['PRECIO'],0,",",".").'</td>';
    echo '<td>'.number_format($value['STOCK_DISPONIBLE'],0,",",".").'</td>';
    echo '<td>'.number_format($value['PRECIO_CENTRAL'],0,",",".").'</td>';
    echo '<td>'.$value['ESTADO'].'</td>';
    if($value['ESTADO']=='DIF PRECIO' || $value['ESTADO']=='DIF STOCK'){
        ?>
            <td><button class="btn btn-sm btn-warning" onClick="actualizar('<?=$value['COD_ARTICU']?>')">Actualizar</button></td>
        <?php
    }else{
        echo '<td></td>';
    }
    echo '</tr>';
}
?>
</tbody>

</table>



<!-- <script src="assets/bootstrap/jquery-3.5.1.slim.min.js"></script>
<script src="assets/bootstrap/popper.min.js" ></script>
<script src="assets/bootstrap/bootstrap.min.js" ></script> -->

<script src="Controlador/main.js"></script>
    
</body>
</html>



