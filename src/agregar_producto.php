<?php
define('IS_TEST_ENV', true);
ob_start(); // Inicia el buffer de salida

require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/login_helper.php";

$id_user = iniciarSesionYValidarPermisos($conexion, "productos");

if (empty($_GET['id'])) {
    if (!headers_sent()) {
        header("Location: productos.php");
    }
    exit();
} else {
    $id_producto_seguro = $_GET['id'];
    if (!is_numeric($id_producto_seguro)) {
        if (!headers_sent()) {
            header("Location: productos.php");
        }
        exit();
    }

    $consulta_segura = $conexion->prepare("SELECT * FROM producto WHERE codproducto = ?");
    $consulta_segura->bind_param("i", $id_producto_seguro);
    $consulta_segura->execute();
    $consulta = $consulta_segura->get_result();
    $data_producto = mysqli_fetch_assoc($consulta);
    $id_producto = $id_producto_seguro;
}

if (!empty($_POST)) {
    $alert = "";
    if (!empty($_POST['cantidad']) || !empty($_POST['precio'])) {
        $precio_seguro = $_POST['precio'];
        $cantidad_segura = $_POST['cantidad'];
        $producto_id_seguro = $id_producto_seguro;
        $precio = $precio_seguro;
        $cantidad = $cantidad_segura;
        $producto_id = $producto_id_seguro;
        $total = $cantidad + $data_producto['existencia'];
        $query_insert_seguro = $conexion->prepare("UPDATE producto SET existencia = ? WHERE codproducto = ?");
        $query_insert_seguro->bind_param("ii", $total, $producto_id_seguro);
        $query_insert_seguro->execute();
        if ($query_insert_seguro->affected_rows > 0) {
            $alert = '<div class="alert alert-success" role="alert">Stock actualizado</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al ingresar la cantidad</div>';
        }
        mysqli_close($conexion);
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son obligatorios</div>';
    }
}

ob_end_flush(); // Finaliza el buffer de salida y envía la salida
?>
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                Agregar Producto
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="precio">Precio Actual</label>
                        <input type="text" class="form-control" value="<?php echo $data_producto['precio']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="precio">Cantidad de productos Disponibles</label>
                        <input type="number" class="form-control" value="<?php echo $data_producto['existencia']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="precio">Nuevo Precio</label>
                        <input type="text" placeholder="Ingrese nombre del precio" name="precio" class="form-control" value="<?php echo $data_producto['precio']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Agregar Cantidad</label>
                        <input type="number" placeholder="Ingrese cantidad" name="cantidad" id="cantidad" class="form-control">
                    </div>
                    <input type="submit" value="Actualizar" class="btn btn-primary">
                    <a href="productos.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
