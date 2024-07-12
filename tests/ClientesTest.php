<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase ClienteModelTest
require_once __DIR__ . '/../src/ClienteModelTest.php';

class ClientesTest extends TestCase
{
    protected $conexion;
    protected $clienteModel;

    protected function setUp(): void
    {
        $this->conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

        $this->conexion->query("TRUNCATE TABLE usuario");
        $this->conexion->query("TRUNCATE TABLE cliente");
        $this->conexion->query("INSERT INTO usuario (idusuario, nombre, correo, usuario, clave, estado) VALUES (1, 'Aaron Pedro Paco Ramos', 'ppacoramos@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1)");

        $this->clienteModel = new ClienteModelTest($this->conexion);
    }

    public function testRegisterNewClient()
    {
        $resultado = $this->clienteModel->registrarCliente('Nuevo Cliente', '123456789', 'Dirección de Prueba', 1);

        $result = $this->conexion->query("SELECT * FROM cliente WHERE nombre = 'Nuevo Cliente'");
        $this->assertEquals(1, $result->num_rows);

        $this->assertEquals('Cliente registrado', $resultado);
    }

    protected function tearDown(): void
    {
        $this->conexion->close();
    }
}
