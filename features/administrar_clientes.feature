Feature: Administrar Clientes
  Como Personal administrativo
  Quiero administrar clientes en el sistema
  Para poder crear, visualizar, actualizar y eliminar clientes

  Scenario: Crear Cliente
    Given que el Personal navega a la página de administración de clientes
    And selecciona "Crear nuevo cliente"
    And no ingresa datos enviando el formulario
    And envía el formulario
    Then el sistema muestra un mensaje de error "Los campos del formulario no pueden estar vacíos"
    And completa el formulario con la información del cliente
    And envía el formulario
    Then el sistema guarda el nuevo cliente en la base de datos
    And muestra un mensaje de confirmación

  Scenario: Visualizar Clientes
    Given que el Personal navega a la página de administración de clientes
    Then el sistema muestra la lista de clientes disponibles

  Scenario: Actualizar Cliente
    Given que el Personal navega a la página de administración de clientes
    And selecciona un cliente para actualizar
    And modifica la información del cliente
    And envía el formulario
    Then el sistema actualiza el cliente en la base de datos
    And muestra un mensaje de confirmación

  Scenario: Eliminar Cliente
    Given que el Personal navega a la página de administración de clientes
    And selecciona un cliente para eliminar
    And confirma la eliminación
    Then el sistema elimina el cliente de la base de datos
    And muestra un mensaje de confirmación