<?php
include "../conexion.php";
include "ProductoModelTest.php"; // Nuevo modelo para manejar la lógica de productos

if (!empty($_POST)) {
  $productoModel = new ProductoModelTest($conexion);
  $alert = $productoModel->actualizarProducto($_GET['id'], $_POST['codigo'], $_POST['producto'], $_POST['precio']);
  mysqli_close($conexion);
  echo $alert;
}

if (empty($_REQUEST['id'])) {
  header("Location: productos.php");
} else {
  $id_productoSeguro = $_REQUEST['id'];
  if (!is_numeric($id_productoSeguro)) {
    header("Location: productos.php");
  }

  $productoModel = new ProductoModelTest($conexion);
  $data_producto = $productoModel->obtenerProducto($id_productoSeguro);
  if (!$data_producto) {
    header("Location: productos.php");
  }
}
?>
