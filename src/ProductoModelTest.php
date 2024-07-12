<?php

class ProductoModelTest
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function actualizarProducto($id_producto, $codigo, $descripcion, $precio)
    {
        // Obtener datos actuales del producto
        $consulta_segura = $this->conexion->prepare("SELECT * FROM producto WHERE codproducto = ?");
        $consulta_segura->bind_param("i", $id_producto);
        $consulta_segura->execute();
        $consulta = $consulta_segura->get_result();
        $data_producto = mysqli_fetch_assoc($consulta);

        if ($data_producto) {
            $query_update_seguro = $this->conexion->prepare("UPDATE producto SET codigo = ?, descripcion = ?, precio = ? WHERE codproducto = ?");
            $query_update_seguro->bind_param("ssdi", $codigo, $descripcion, $precio, $id_producto);
            $query_update_seguro->execute();

            if ($query_update_seguro->affected_rows > 0) {
                return '<div class="alert alert-primary" role="alert">Producto Modificado</div>';
            } else {
                return '<div class="alert alert-primary" role="alert">Error al Modificar</div>';
            }
        } else {
            return '<div class="alert alert-danger" role="alert">Producto no encontrado</div>';
        }
    }

    public function obtenerProducto($id_producto)
    {
        $query_producto_seguro = $this->conexion->prepare("SELECT * FROM producto WHERE codproducto = ?");
        $query_producto_seguro->bind_param("i", $id_producto);
        $query_producto_seguro->execute();
        $result_producto_seguro = $query_producto_seguro->get_result();

        if ($result_producto_seguro->num_rows > 0) {
            return $result_producto_seguro->fetch_assoc();
        } else {
            return false;
        }
    }

    public function eliminarProducto($id)
    {
        // Usar prepared statements para prevenir inyección SQL
        $stmt = $this->conexion->prepare("UPDATE producto SET estado = 0 WHERE codproducto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
