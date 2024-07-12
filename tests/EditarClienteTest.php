<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase ClienteModelTest
require_once __DIR__ . '/../src/ClienteModelTest.php';

class EditarClienteTest extends TestCase
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

    public function testActualizarCliente()
    {
        // Llamar a la función para actualizar un cliente
        $resultado = $this->clienteModel->actualizarCliente(1, 'Nuevo Cliente', '987654321', 'Nueva Dirección');

        // Verificar que el cliente fue actualizado con éxito
        $result = $this->conexion->query("SELECT * FROM cliente WHERE idcliente = 1");
        $cliente = mysqli_fetch_assoc($result);

        $this->assertEquals('Nuevo Cliente', $cliente['nombre']);
        $this->assertEquals('987654321', $cliente['telefono']);
        $this->assertEquals('Nueva Dirección', $cliente['direccion']);
        $this->assertStringContainsString('Cliente Actualizado correctamente', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
