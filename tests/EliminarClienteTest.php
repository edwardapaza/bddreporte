<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase ClienteModelTest
require_once __DIR__ . '/../src/ClienteModelTest.php';

class EliminarClienteTest extends TestCase
{
    protected $conexion;
    protected $clienteModel;

    protected function setUp(): void
    {
        // Configurar conexión a la base de datos de pruebas
        $this->conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

        // Limpiar la tabla de clientes y añadir datos de prueba
        $this->conexion->query("TRUNCATE TABLE cliente");
        $this->conexion->query("INSERT INTO cliente (idcliente, nombre, telefono, direccion, usuario_id, estado) VALUES (1, 'Cliente de Prueba', '123456789', 'Dirección de Prueba', 1, 1)");

        // Crear una instancia de ClienteModelTest
        $this->clienteModel = new ClienteModelTest($this->conexion);
    }

    public function testEliminarCliente()
    {
        // Llamar a la función para eliminar un cliente
        $this->clienteModel->eliminarCliente(1);

        // Verificar que el cliente fue eliminado (estado = 0)
        $result = $this->conexion->query("SELECT * FROM cliente WHERE idcliente = 1");
        $cliente = mysqli_fetch_assoc($result);

        $this->assertEquals(0, $cliente['estado']);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
