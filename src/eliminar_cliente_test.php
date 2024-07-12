<?php
include "../conexion.php";
include "ClienteModelTest.php"; // Nuevo modelo para manejar la lógica de clientes

if (!empty($_GET['id'])) {
    $clienteModel = new ClienteModelTest($conexion);
    $clienteModel->eliminarCliente($_GET['id']);
    mysqli_close($conexion);
}
?>
