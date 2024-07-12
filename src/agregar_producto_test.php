<?php
include __DIR__ . "/../conexion.php";
include __DIR__ . "/ProductoModelTest.php"; // Nuevo modelo para manejar la lógica de productos

if (!empty($_POST)) {
    $alert = "";
    if (!empty($_POST['cantidad']) || !empty($_POST['precio'])) {
        $precio_seguro = $_POST['precio'];
        $cantidad_segura = $_POST['cantidad'];
        $producto_id_seguro = $_POST['id'];
        $descripcion_segura = $_POST['descripcion']; // Asumiendo que este es el cuarto argumento necesario

        $productoModel = new ProductoModelTest($conexion);
        $alert = $productoModel->actualizarProducto($producto_id_seguro, $precio_seguro, $cantidad_segura, $descripcion_segura);
    } else {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    }
    mysqli_close($conexion);
}
?>
<?php echo isset($alert) ? $alert : ''; ?>
