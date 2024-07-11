Feature: Administrar Permisos
  As a Personal administrativo
  I want to administrar los permisos de los usuarios en el sistema
  So that I can otorgar y revocar permisos

  Scenario: Otorgar y Revocar Permisos
    Given el Personal navega a la página de administración de permisos
    And selecciona los permisos a otorgar o revocar
    Then el sistema actualiza los permisos en la base de datos
    And muestra un mensaje de confirmación para permisos
