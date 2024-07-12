<?php

class UsuarioModelTest
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function registrarUsuario($nombre, $correo, $usuario, $clave)
    {
        // Verificar si el correo ya existe
        $query_seguro = $this->conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
        $query_seguro->bind_param("s", $correo);
        $query_seguro->execute();
        $result_seguro = $query_seguro->get_result();

        if ($result_seguro->num_rows > 0) {
            return '<div class="alert alert-warning" role="alert">El correo ya existe</div>';
        } else {
            // Registrar el nuevo usuario
            $query_insert_seguro = $this->conexion->prepare("INSERT INTO usuario(nombre, correo, usuario, clave) VALUES (?, ?, ?, ?)");
            $query_insert_seguro->bind_param("ssss", $nombre, $correo, $usuario, $clave);
            $query_insert_seguro->execute();

            if ($query_insert_seguro->affected_rows > 0) {
                return '<div class="alert alert-primary" role="alert">Usuario registrado</div>';
            } else {
                return '<div class="alert alert-danger" role="alert">Error al registrar</div>';
            }
        }
    }

    public function eliminarUsuario($id)
    {
        // Uso de prepared statement para evitar inyección SQL
        $query_delete = $this->conexion->prepare("UPDATE usuario SET estado = 0 WHERE idusuario = ?");
        $query_delete->bind_param("i", $id);
        $query_delete->execute();

        if ($query_delete->affected_rows > 0) {
            return 'Usuario eliminado';
        } else {
            return 'Error al eliminar usuario';
        }
    }

    public function actualizarUsuario($idusuario, $nombre, $correo, $usuario)
    {
        // Cambio: Usando prepared statements para prevenir inyección SQL
        $sql_update_seguro = $this->conexion->prepare("UPDATE usuario SET nombre = ?, correo = ?, usuario = ? WHERE idusuario = ?");
        $sql_update_seguro->bind_param("sssi", $nombre, $correo, $usuario, $idusuario);
        $sql_update_seguro->execute();

        if ($sql_update_seguro->affected_rows > 0) {
            return '<div class="alert alert-success" role="alert">Usuario Actualizado</div>';
        } else {
            return '<div class="alert alert-danger" role="alert">Error al Actualizar el Usuario</div>';
        }
    }
}
?>
