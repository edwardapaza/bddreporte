<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase ProductoModelTest
require_once __DIR__ . '/../src/ProductoModelTest.php';

class EliminarProductoTest extends TestCase
{
    protected $conexion;
    protected $productoModel;

    protected function setUp(): void
    {
        // Configurar conexión a la base de datos de pruebas
        $this->conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

        // Limpiar la tabla de productos y añadir datos de prueba
        $this->conexion->query("TRUNCATE TABLE producto");
        $this->conexion->query("INSERT INTO producto (codproducto, codigo, descripcion, precio, existencia, usuario_id, estado) VALUES (1, '123456', 'Producto de Prueba', 100, 10, 1, 1)");

        // Crear una instancia de ProductoModelTest
        $this->productoModel = new ProductoModelTest($this->conexion);
    }

    public function testEliminarProducto()
    {
        // Llamar a la función para eliminar un producto
        $this->productoModel->eliminarProducto(1);

        // Verificar que el producto fue eliminado (estado = 0)
        $result = $this->conexion->query("SELECT * FROM producto WHERE codproducto = 1");
        $producto = mysqli_fetch_assoc($result);

        $this->assertEquals(0, $producto['estado']);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
