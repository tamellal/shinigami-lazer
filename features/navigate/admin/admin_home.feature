Feature: Admin area
  In order to use the admin area
  As an admin
  I need to be able to access to admin area

  Background:
    Given the following fixtures are loaded:
      | AdminFixtures |


  @javascript
  Scenario: Admin area
    Given I am logged as "admin@shinigami-laser.com" with "test" password
    And I wait "2"
    When I am on "/admin"
    Then I should see "ShinigAdmin"