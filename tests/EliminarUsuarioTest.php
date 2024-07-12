<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase UsuarioModelTest
require_once __DIR__ . '/../src/UsuarioModelTest.php';

class EliminarUsuarioTest extends TestCase
{
    protected $conexion;
    protected $usuarioModel;

    protected function setUp(): void
    {
        // Configurar conexión a la base de datos de pruebas
        $this->conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

        // Limpiar la tabla de usuarios y añadir el usuario conocido
        $this->conexion->query("TRUNCATE TABLE usuario");
        $this->conexion->query("INSERT INTO usuario (idusuario, nombre, correo, usuario, clave, estado) VALUES (1, 'Aaron Pedro Paco Ramos', 'ppacoramos@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1)");

        // Crear una instancia de UsuarioModelTest
        $this->usuarioModel = new UsuarioModelTest($this->conexion);
    }

    public function testEliminarUsuario()
    {
        // Intentar eliminar el usuario con ID 1
        $resultado = $this->usuarioModel->eliminarUsuario(1);

        // Verificar que el usuario fue eliminado con éxito
        $result = $this->conexion->query("SELECT estado FROM usuario WHERE idusuario = 1");
        $usuario = mysqli_fetch_assoc($result);

        $this->assertEquals(0, $usuario['estado']);
        $this->assertStringContainsString('Usuario eliminado', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
