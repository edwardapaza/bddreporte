<?php

class RolModelTest
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function actualizarPermisos($id_usuario, $permisos)
    {
        // Consulta segura para eliminar los permisos del usuario
        $deleteSeguro = $this->conexion->prepare("DELETE FROM detalle_permisos WHERE id_usuario = ?");
        $deleteSeguro->bind_param("i", $id_usuario);
        $deleteSeguro->execute();

        if ($permisos != "") {
            foreach ($permisos as $permiso) {
                // Consulta segura para insertar los permisos del usuario
                $insertSeguro = $this->conexion->prepare("INSERT INTO detalle_permisos(id_usuario, id_permiso) VALUES (?, ?)");
                $insertSeguro->bind_param("ii", $id_usuario, $permiso);
                $insertSeguro->execute();
            }
            return 'Permisos actualizados';
        } else {
            return 'No se asignaron permisos';
        }
    }
}
?>
