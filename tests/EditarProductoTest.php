<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase ProductoModelTest
require_once __DIR__ . '/../src/ProductoModelTest.php';

class EditarProductoTest extends TestCase
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

    public function testActualizarProducto()
    {
        // Llamar a la función para actualizar un producto con los cuatro argumentos
        $resultado = $this->productoModel->actualizarProducto(1, '654321', 'Producto Actualizado', 200);

        // Verificar que el producto fue actualizado con éxito
        $result = $this->conexion->query("SELECT * FROM producto WHERE codproducto = 1");
        $producto = mysqli_fetch_assoc($result);

        $this->assertEquals('654321', $producto['codigo']);
        $this->assertEquals('Producto Actualizado', $producto['descripcion']);
        $this->assertEquals(200, $producto['precio']);
        $this->assertStringContainsString('Producto Modificado', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
