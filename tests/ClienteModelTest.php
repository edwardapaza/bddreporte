<?php

class ClienteModelTest
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function registrarCliente($nombre, $telefono, $direccion, $usuario_id)
    {
        $querySeguro = $this->conexion->prepare("SELECT * FROM cliente WHERE nombre = ?");
        $querySeguro->bind_param("s", $nombre);
        $querySeguro->execute();
        $resultSeguro = $querySeguro->get_result();

        if ($resultSeguro->num_rows > 0) {
            return 'El cliente ya existe';
        } else {
            $query_insert_seguro = $this->conexion->prepare("INSERT INTO cliente(nombre, telefono, direccion, usuario_id) VALUES (?, ?, ?, ?)");
            $query_insert_seguro->bind_param("sssi", $nombre, $telefono, $direccion, $usuario_id);
            $query_insert_seguro->execute();

            if ($query_insert_seguro->affected_rows > 0) {
                return 'Cliente registrado';
            } else {
                return 'Error al registrar';
            }
        }
    }

    public function actualizarCliente($idcliente, $nombre, $telefono, $direccion)
    {
        // Usar prepared statements para prevenir inyección SQL
        $sql_update_seguro = $this->conexion->prepare("UPDATE cliente SET nombre = ?, telefono = ?, direccion = ? WHERE idcliente = ?");
        $sql_update_seguro->bind_param("sssi", $nombre, $telefono, $direccion, $idcliente);
        $sql_update_seguro->execute();

        if ($sql_update_seguro->affected_rows > 0) {
            return '<div class="alert alert-success" role="alert">Cliente Actualizado correctamente</div>';
        } else {
            return '<div class="alert alert-danger" role="alert">Error al Actualizar el Cliente</div>';
        }
    }

    public function eliminarCliente($id)
    {
        // Usar prepared statements para prevenir inyección SQL
        $stmt = $this->conexion->prepare("UPDATE cliente SET estado = 0 WHERE idcliente = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
