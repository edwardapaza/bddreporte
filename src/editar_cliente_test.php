<?php
include "../conexion.php";
include "ClienteModelTest.php"; // Nuevo modelo para manejar la lógica de clientes

if ($_POST) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $clienteModel = new ClienteModelTest($conexion);
        $alert = $clienteModel->actualizarCliente($_POST['id'], $_POST['nombre'], $_POST['telefono'], $_POST['direccion']);
    }
    mysqli_close($conexion);
}
?>
<?php echo isset($alert) ? $alert : ''; ?>
