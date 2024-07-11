Feature: Administrar Usuarios
  As a Personal administrativo
  I want to administrar usuarios en el sistema
  So that I can crear, visualizar, actualizar y eliminar usuarios

  Scenario: Crear Usuario
    Given el Personal navega a la página de administración de usuarios
    And selecciona "Crear nuevo usuario"
    And no ingresa datos enviando el formulario de usuarios
    And envía el formulario de usuarios
    Then el sistema muestra un mensaje de error "Los campos del formulario de usuarios no pueden estar vacíos"
    And completa el formulario con la información del usuario
    And envía el formulario de usuarios
    Then el sistema guarda el nuevo usuario en la base de datos
    And muestra un mensaje de confirmación para usuarios

  Scenario: Visualizar Usuarios
    Given el Personal navega a la página de administración de usuarios
    Then el sistema muestra la lista de usuarios disponibles

  Scenario: Actualizar Usuario
    Given el Personal navega a la página de administración de usuarios
    And selecciona un usuario para actualizar
    And modifica la información del usuario
    And envía el formulario de usuarios
    Then el sistema actualiza el usuario en la base de datos
    And muestra un mensaje de confirmación para usuarios

  Scenario: Eliminar Usuario
    Given el Personal navega a la página de administración de usuarios
    And selecciona un usuario para eliminar de la lista
    And confirma la eliminación del usuario
    Then el sistema elimina el usuario de la base de datos
    And muestra un mensaje de confirmación para usuarios