Feature: Administrar Ventas
  As a Personal administrativo
  I want to administrar ventas en el sistema
  So that I can visualizar, actualizar y eliminar ventas

  Scenario: Visualizar Ventas
    Given el Personal navega a la página de administración de ventas
    Then el sistema muestra la lista de ventas disponibles

  Scenario: Actualizar Venta
    Given el Personal navega a la página de administración de ventas
    And selecciona una venta para actualizar
    And modifica la información de la venta con datos incompletos
    And envía el formulario de ventas
    Then el sistema muestra un mensaje de error para ventas "Los campos del formulario no pueden estar vacíos"
    And completa el formulario con la información correcta de la venta
    And envía el formulario de ventas
    Then el sistema actualiza la venta en la base de datos
    And muestra un mensaje de confirmación para ventas actualizado

  Scenario: Eliminar Venta
    Given el Personal navega a la página de administración de ventas
    And selecciona una venta para eliminar
    And confirma la eliminación de la venta
    Then el sistema elimina la venta de la base de datos
    And muestra un mensaje de confirmación para ventas eliminado
