<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase ConfiguracionModelTest
require_once __DIR__ . '/../src/ConfiguracionModelTest.php';

class ConfigTest extends TestCase
{
    protected $conexion;
    protected $configuracionModel;

    protected function setUp(): void
    {
        // Configurar conexión a la base de datos de pruebas
        $this->conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

        // Limpiar la tabla de configuración y añadir datos de prueba
        $this->conexion->query("TRUNCATE TABLE configuracion");
        $this->conexion->query("INSERT INTO configuracion (id, nombre, telefono, email, direccion) VALUES (1, 'Empresa de Prueba', '123456789', 'empresa@prueba.com', 'Dirección de Prueba')");

        // Crear una instancia de ConfiguracionModelTest
        $this->configuracionModel = new ConfiguracionModelTest($this->conexion);
    }

    public function testActualizarConfiguracion()
    {
        // Llamar a la función para actualizar la configuración
        $resultado = $this->configuracionModel->actualizarConfiguracion(1, 'Nueva Empresa', '987654321', 'nuevo@empresa.com', 'Nueva Dirección');

        // Verificar que la configuración fue actualizada con éxito
        $result = $this->conexion->query("SELECT * FROM configuracion WHERE id = 1");
        $config = mysqli_fetch_assoc($result);

        $this->assertEquals('Nueva Empresa', $config['nombre']);
        $this->assertEquals('987654321', $config['telefono']);
        $this->assertEquals('nuevo@empresa.com', $config['email']);
        $this->assertEquals('Nueva Dirección', $config['direccion']);
        $this->assertStringContainsString('Datos modificados', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
