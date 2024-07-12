<?php
include "../conexion.php";
include "ProductoModelTest.php"; // Nuevo modelo para manejar la lógica de productos

if (!empty($_GET['id'])) {
    $productoModel = new ProductoModelTest($conexion);
    $productoModel->eliminarProducto($_GET['id']);
    mysqli_close($conexion);
}
?>
