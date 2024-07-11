Feature: Administrar Productos
  As a Personal administrativo
  I want to administrar productos en el sistema
  So that I can crear, visualizar, actualizar y eliminar productos

  Scenario: Crear Producto
    Given el Personal ha navegado a la página de administración de productos
    When crea un nuevo producto con nombre "Nuevo Producto", precio "100" y descripción "Descripción del nuevo producto"
    Then el sistema debería guardar el nuevo producto en la base de datos
    And debería mostrar un mensaje de confirmación

  Scenario: Visualizar Productos
    Given el Personal ha navegado a la página de administración de productos
    Then el sistema debería mostrar la lista de productos disponibles

  Scenario: Actualizar Producto
    Given el Personal ha navegado a la página de administración de productos
    And hay un producto llamado "Producto a Actualizar"
    When actualiza el producto con nombre "Producto a Actualizar" para que tenga precio "150" y descripción "Descripción actualizada del producto"
    Then el sistema debería actualizar el producto en la base de datos
    And debería mostrar un mensaje de confirmación

  Scenario: Eliminar Producto
    Given el Personal ha navegado a la página de administración de productos
    And hay un producto llamado "Producto a Eliminar"
    When elimina el producto con nombre "Producto a Eliminar"
    Then el sistema debería eliminar el producto de la base de datos
    And debería mostrar un mensaje de confirmación