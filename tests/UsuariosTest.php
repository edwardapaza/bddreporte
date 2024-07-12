<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase UsuarioModelTest
require_once __DIR__ . '/../src/UsuarioModelTest.php';

class UsuariosTest extends TestCase
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

    public function testRegistrarUsuario()
    {
        // Intentar registrar un nuevo usuario diferente para evitar conflicto con el usuario existente
        $resultado = $this->usuarioModel->registrarUsuario('Nuevo Usuario', 'nuevo@example.com', 'nuevo_usuario', md5('nuevo123'));

        // Verificar que el usuario fue registrado con éxito
        $result = $this->conexion->query("SELECT * FROM usuario WHERE correo = 'nuevo@example.com'");
        $usuario = mysqli_fetch_assoc($result);

        $this->assertEquals('Nuevo Usuario', $usuario['nombre']);
        $this->assertEquals('nuevo@example.com', $usuario['correo']);
        $this->assertEquals('nuevo_usuario', $usuario['usuario']);
        $this->assertEquals(md5('nuevo123'), $usuario['clave']);
        $this->assertStringContainsString('Usuario registrado', $resultado);
    }

    public function testRegistrarUsuarioExistente()
    {
        // Intentar registrar un usuario con el mismo correo
        $resultado = $this->usuarioModel->registrarUsuario('Aaron Pedro Paco Ramos', 'ppacoramos@gmail.com', 'admin2', md5('clave1234'));

        // Verificar que el mensaje sea de que el correo ya existe
        $this->assertStringContainsString('El correo ya existe', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
