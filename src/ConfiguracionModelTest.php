<?php

class ConfiguracionModelTest
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function actualizarConfiguracion($id, $nombre, $telefono, $email, $direccion)
    {
        // Usar prepared statements para prevenir inyección SQL
        $query_update = $this->conexion->prepare("UPDATE configuracion SET nombre = ?, telefono = ?, email = ?, direccion = ? WHERE id = ?");
        $query_update->bind_param("ssssi", $nombre, $telefono, $email, $direccion, $id);
        $query_update->execute();

        if ($query_update->affected_rows > 0) {
            return '<div class="alert alert-success" role="alert">
                        Datos modificados
                    </div>';
        } else {
            return '<div class="alert alert-danger" role="alert">
                        Error al modificar los datos
                    </div>';
        }
    }
}
?>
