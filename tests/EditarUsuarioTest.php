<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase UsuarioModelTest
require_once __DIR__ . '/../src/UsuarioModelTest.php';

class EditarUsuarioTest extends TestCase
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

    public function testActualizarUsuario()
    {
        // Intentar actualizar el usuario con ID 1
        $resultado = $this->usuarioModel->actualizarUsuario(1, 'Aaron Modificado', 'modificado@gmail.com', 'admin_modificado');

        // Verificar que el usuario fue actualizado con éxito
        $result = $this->conexion->query("SELECT * FROM usuario WHERE idusuario = 1");
        $usuario = mysqli_fetch_assoc($result);

        $this->assertEquals('Aaron Modificado', $usuario['nombre']);
        $this->assertEquals('modificado@gmail.com', $usuario['correo']);
        $this->assertEquals('admin_modificado', $usuario['usuario']);
        $this->assertStringContainsString('Usuario Actualizado', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
