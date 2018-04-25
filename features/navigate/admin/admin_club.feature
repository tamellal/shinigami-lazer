Feature: Admin club
  In order to manage the clubs
  As an admin
  I need to be able to CRUD the clubs

  Background:
    Given the following fixtures are loaded:
      | AdminFixtures |


  @javascript
  Scenario: Clubs list
    Given I am logged as "admin@shinigami-laser.com" with "test" password
    And I wait "2"
    When I am on "admin/club"
    Then I should see "Liste des clubs"

  @javascript
  Scenario: Club CRUD
    Given I am logged as "admin@shinigami-laser.com" with "test" password
    And I wait "2"
    When I am on "admin/club"
    And I follow "Nouveau"
    Then I should see "Création de club"

    When I fill in "Code" with "113"
    And  I fill in "Adresse" with "Paris 13"
    And I press "Valider"
    Then I should have the clubCode "113" in database
    And I should see "113"
    And I should see "Paris 13"

    When I follow "Mettre à jour"
    Then I should see "Mise à jour de club"

    When I fill in "Code" with "112"
    And I fill in "Adresse" with "Paris 12"
    And I press "Valider"
    Then I should have the clubCode "112" in database
    And I should see "112"
    And I should see "Paris 12"

    When I follow "Supprimer"
    Then I should not see "112"
    And I should not see "Paris 12"