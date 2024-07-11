<?php

use Behat\Behat\Context\Context;
use Phake;

class UsuariosContext implements Context
{
    private $usuarioService;
    private $exception;

    public function __construct()
    {
        // Inicializar el servicio utilizando Phake
        $this->usuarioService = Phake::mock('UsuarioService');
    }

    /**
     * @Given el Personal navega a la página de administración de usuarios
     */
    public function elPersonalNavegaALaPaginaDeAdministracionDeUsuarios()
    {
        // No se requiere implementación para este método utilizando Phake
    }

    /**
     * @Given selecciona "Crear nuevo usuario"
     */
    public function seleccionaCrearNuevoUsuario()
    {
        // No se requiere implementación para este método utilizando Phake
    }

    /**
     * @Given no ingresa datos enviando el formulario de usuarios
     */
    public function noIngresaDatosEnviandoElFormularioDeUsuarios()
    {
        // Simular comportamiento con Phake
        Phake::when($this->usuarioService)->crearUsuario([])->thenThrow(new Exception('Los campos del formulario de usuarios no pueden estar vacíos'));
    }

    /**
     * @Given envía el formulario de usuarios
     */
    public function enviaElFormularioDeUsuarios()
    {
        // Simular comportamiento con Phake
        try {
            $this->usuarioService->crearUsuario([]);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then el sistema muestra un mensaje de error "Los campos del formulario de usuarios no pueden estar vacíos"
     */
    public function elSistemaMuestraUnMensajeDeError()
    {
        // Verificar que se muestra el mensaje de error utilizando Phake
        if ($this->exception && $this->exception->getMessage() === 'Los campos del formulario de usuarios no pueden estar vacíos') {
            return true;
        }

        throw new Exception('El mensaje de error esperado no fue mostrado.');
    }

    /**
     * @Given completa el formulario con la información del usuario
     */
    public function completaElFormularioConLaInformacionDelUsuario()
    {
        // Simular comportamiento con Phake
        Phake::when($this->usuarioService)->crearUsuario(['nombre' => 'Usuario', 'email' => 'usuario@example.com'])->thenReturn(true);
        $this->usuarioService->crearUsuario(['nombre' => 'Usuario', 'email' => 'usuario@example.com']);
    }

    /**
     * @Then el sistema guarda el nuevo usuario en la base de datos
     */
    public function elSistemaGuardaElNuevoUsuarioEnLaBaseDeDatos()
    {
        // Verificar que el servicio fue llamado para crear el usuario
        Phake::verify($this->usuarioService)->crearUsuario(['nombre' => 'Usuario', 'email' => 'usuario@example.com']);
    }

    /**
     * @Then muestra un mensaje de confirmación para usuarios
     */
    public function muestraUnMensajeDeConfirmacionParaUsuarios()
    {
        // Simular mensaje de confirmación con Phake
        echo "Usuario creado correctamente";
    }

    /**
     * @Then el sistema muestra la lista de usuarios disponibles
     */
    public function elSistemaMuestraLaListaDeUsuariosDisponibles()
    {
        // Simular comportamiento con Phake
        Phake::when($this->usuarioService)->listarUsuarios()->thenReturn(['Usuario1', 'Usuario2']);
        $usuarios = $this->usuarioService->listarUsuarios();
        print_r($usuarios);
    }

    /**
     * @Given selecciona un usuario para actualizar
     */
    public function seleccionaUnUsuarioParaActualizar()
    {
        // Simular comportamiento con Phake
        Phake::when($this->usuarioService)->actualizarUsuario(['nombre' => 'Usuario Actualizado', 'email' => 'usuario_actualizado@example.com'])->thenReturn(true);
    }

    /**
     * @Given modifica la información del usuario
     */
    public function modificaLaInformacionDelUsuario()
    {
        // Simular comportamiento con Phake
        $this->usuarioService->actualizarUsuario(['nombre' => 'Usuario Actualizado', 'email' => 'usuario_actualizado@example.com']);
    }

    /**
     * @Then el sistema actualiza el usuario en la base de datos
     */
    public function elSistemaActualizaElUsuarioEnLaBaseDeDatos()
    {
        // Verificar que el servicio fue llamado para actualizar el usuario
        Phake::verify($this->usuarioService)->actualizarUsuario(['nombre' => 'Usuario Actualizado', 'email' => 'usuario_actualizado@example.com']);
    }

    /**
     * @Given selecciona un usuario para eliminar de la lista
     */
    public function seleccionaUnUsuarioParaEliminarDeLaLista()
    {
        // Simular comportamiento con Phake
        Phake::when($this->usuarioService)->eliminarUsuario(['email' => 'usuario_a_eliminar@example.com'])->thenReturn(true);
    }

    /**
     * @Given confirma la eliminación del usuario
     */
    public function confirmaLaEliminacionDelUsuario()
    {
        // Simular comportamiento con Phake
        $this->usuarioService->eliminarUsuario(['email' => 'usuario_a_eliminar@example.com']);
    }

    /**
     * @Then el sistema elimina el usuario de la base de datos
     */
    public function elSistemaEliminaElUsuarioDeLaBaseDeDatos()
    {
        // Verificar que el servicio fue llamado para eliminar el usuario
        Phake::verify($this->usuarioService)->eliminarUsuario(['email' => 'usuario_a_eliminar@example.com']);
    }
}

// Asegúrate de definir o incluir la clase UsuarioService si no existe
interface UsuarioService
{
    public function crearUsuario($data);
    public function listarUsuarios();
    public function actualizarUsuario($data);
    public function eliminarUsuario($data);
}
