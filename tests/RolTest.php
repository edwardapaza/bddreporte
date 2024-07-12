<?php

use PHPUnit\Framework\TestCase;

// Incluir el archivo de la clase RolModelTest
require_once __DIR__ . '/../src/RolModelTest.php';

class RolTest extends TestCase
{
    protected $conexion;
    protected $rolModel;

    protected function setUp(): void
    {
        // Configurar conexión a la base de datos de pruebas
        $this->conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

        // Limpiar la tabla de permisos y detalle_permisos, y añadir datos de prueba
        $this->conexion->query("TRUNCATE TABLE permisos");
        $this->conexion->query("TRUNCATE TABLE detalle_permisos");
        $this->conexion->query("TRUNCATE TABLE usuario");
        $this->conexion->query("INSERT INTO permisos (id, nombre) VALUES 
            (1, 'configuración'), 
            (2, 'usuarios'), 
            (3, 'clientes'), 
            (4, 'productos'), 
            (5, 'ventas'), 
            (6, 'nueva_venta')");
        $this->conexion->query("INSERT INTO usuario (idusuario, nombre, correo, usuario, clave, estado) VALUES 
            (1, 'Aaron Pedro Paco Ramos', 'ppacoramos@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1)");

        // Crear una instancia de RolModelTest
        $this->rolModel = new RolModelTest($this->conexion);
    }

    public function testActualizarPermisos()
    {
        // Intentar actualizar los permisos del usuario con ID 1
        $resultado = $this->rolModel->actualizarPermisos(1, [1, 2, 3, 4, 5, 6]);

        // Verificar que los permisos fueron actualizados con éxito
        $result = $this->conexion->query("SELECT * FROM detalle_permisos WHERE id_usuario = 1");
        $permisos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $permisos[] = $row['id_permiso'];
        }

        $this->assertEquals([1, 2, 3, 4, 5, 6], $permisos);
        $this->assertEquals('Permisos actualizados', $resultado);
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos después de cada prueba
        $this->conexion->close();
    }
}
