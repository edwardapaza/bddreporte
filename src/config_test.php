<?php
include "../conexion.php";
include "ConfiguracionModelTest.php"; // Nuevo modelo para manejar la lógica de configuración

if ($_POST) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['email']) || empty($_POST['direccion'])) {
        $alert = '<div class="alert alert-danger" role="alert">
            Todo los campos son obligatorios
        </div>';
    } else {
        $configuracionModel = new ConfiguracionModelTest($conexion);
        $alert = $configuracionModel->actualizarConfiguracion($_POST['id'], $_POST['nombre'], $_POST['telefono'], $_POST['email'], $_POST['direccion']);
    }
    mysqli_close($conexion);
}
?>
<?php echo isset($alert) ? $alert : ''; ?>
