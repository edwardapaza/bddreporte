<?php
function iniciarSesionYValidarPermisos($conexion, $permiso) {
    if (!defined('IS_TEST_ENV')) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['idUser'])) {
            if (!headers_sent()) {
                header("Location: ../index.php");
            }
            exit();
        }

        $id_user = $_SESSION['idUser'];
        $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
        $existe = mysqli_fetch_all($sql);

        if (empty($existe) && $id_user != 1) {
            if (!headers_sent()) {
                header("Location: permisos.php");
            }
            exit();
        }

        return $id_user;
    } else {
        return 1; // o algún valor predeterminado para pruebas
    }
}
?>
