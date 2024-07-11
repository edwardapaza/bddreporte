Feature: Administrar Roles
  As a Personal administrativo
  I want to administrar los roles de los usuarios en el sistema
  So that I can otorgar y modificar roles

  Scenario: Otorgar y Modificar Roles
    Given el Personal navega a la página de administración de roles
    And selecciona el rol a otorgar o modificar
    Then el sistema actualiza el rol en la base de datos
    And muestra un mensaje de confirmación para roles