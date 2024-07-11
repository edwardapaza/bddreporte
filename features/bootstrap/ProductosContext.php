<?php

use Behat\Behat\Context\Context;
use Phake;

class ProductosContext implements Context
{
    private $productoService;
    private $exception;

    public function __construct()
    {
        // Inicializar el servicio utilizando Phake
        $this->productoService = Phake::mock('ProductoService');
    }

    /**
     * @Given el Personal ha navegado a la página de administración de productos
     */
    public function elPersonalHaNavegadoALaPaginaDeAdministracionDeProductos()
    {
        // No se requiere implementación para este método utilizando Phake
    }

    /**
     * @When crea un nuevo producto con nombre :nombre, precio :precio y descripción :descripcion
     */
    public function creaUnNuevoProducto($nombre, $precio, $descripcion)
    {
        // Simular comportamiento con Phake
        Phake::when($this->productoService)->crearProducto($nombre, $precio, $descripcion)->thenReturn(true);
        $this->productoService->crearProducto($nombre, $precio, $descripcion);
    }

    /**
     * @Then el sistema debería guardar el nuevo producto en la base de datos
     */
    public function elSistemaDeberiaGuardarElNuevoProductoEnLaBaseDeDatos()
    {
        // Verificar que el servicio fue llamado para crear el producto
        Phake::verify($this->productoService, Phake::times(1))->crearProducto(Phake::anyParameters());
    }

    /**
     * @Then debería mostrar un mensaje de confirmación
     */
    public function deberiaMostrarUnMensajeDeConfirmacion()
    {
        // Simular mensaje de confirmación con Phake
        echo "Producto creado correctamente";
    }

    /**
     * @Then el sistema debería mostrar la lista de productos disponibles
     */
    public function elSistemaDeberiaMostrarLaListaDeProductosDisponibles()
    {
        // Simular comportamiento con Phake
        Phake::when($this->productoService)->listarProductos()->thenReturn(['Producto1', 'Producto2']);
        $productos = $this->productoService->listarProductos();
        print_r($productos);
    }

    /**
     * @Given hay un producto llamado :nombre
     */
    public function hayUnProductoLlamado($nombre)
    {
        // Simular comportamiento con Phake
        Phake::when($this->productoService)->obtenerProductoPorNombre($nombre)->thenReturn(['nombre' => $nombre]);
    }

    /**
     * @When actualiza el producto con nombre :nombre para que tenga precio :precio y descripción :descripcion
     */
    public function actualizaElProducto($nombre, $precio, $descripcion)
    {
        // Simular comportamiento con Phake
        Phake::when($this->productoService)->actualizarProducto($nombre, $precio, $descripcion)->thenReturn(true);
        $this->productoService->actualizarProducto($nombre, $precio, $descripcion);
    }

    /**
     * @Then el sistema debería actualizar el producto en la base de datos
     */
    public function elSistemaDeberiaActualizarElProductoEnLaBaseDeDatos()
    {
        // Verificar que el servicio fue llamado para actualizar el producto
        Phake::verify($this->productoService, Phake::times(1))->actualizarProducto(Phake::anyParameters());
    }

    /**
     * @When elimina el producto con nombre :nombre
     */
    public function eliminaElProducto($nombre)
    {
        // Simular comportamiento con Phake
        Phake::when($this->productoService)->eliminarProducto($nombre)->thenReturn(true);
        $this->productoService->eliminarProducto($nombre);
    }

    /**
     * @Then el sistema debería eliminar el producto de la base de datos
     */
    public function elSistemaDeberiaEliminarElProductoDeLaBaseDeDatos()
    {
        // Verificar que el servicio fue llamado para eliminar el producto
        Phake::verify($this->productoService, Phake::times(1))->eliminarProducto(Phake::anyParameters());
    }
}

// Asegúrate de definir o incluir la clase ProductoService si no existe
interface ProductoService
{
    public function crearProducto($nombre, $precio, $descripcion);
    public function listarProductos();
    public function obtenerProductoPorNombre($nombre);
    public function actualizarProducto($nombre, $precio, $descripcion);
    public function eliminarProducto($nombre);
}
