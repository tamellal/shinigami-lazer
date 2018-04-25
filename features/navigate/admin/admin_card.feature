Feature: Admin card
  In order to manage the cards
  As an admin
  I need to be able to CRUD the cards

  Background:
    Given the following fixtures are loaded:
      | AdminFixtures |
      | ClubFixtures  |


  @javascript
  Scenario: Cards list
    Given I am logged as "admin@shinigami-laser.com" with "test" password
    And I wait "2"
    When I am on "admin/card"
    Then I should see "Liste des cartes"

  @javascript
  Scenario: Card CRUD
    Given I am logged as "admin@shinigami-laser.com" with "test" password
    And I wait "2"
    When I am on "admin/card"
    And I follow "Nouveau"
    Then I should see "Création de carte"

    When I fill in "CODE_CARTE" with "222222"
    And I press "Appliquer"
    Then I should have the cardCode "222222" in database
    And I should see "113"
    And I should see "222222"
    And I should see "8"

    When I follow "Mettre à jour"
    Then I should see "Mise à jour de carte"

    When I fill in "CODE_CARTE" with "775533"
    And I press "Appliquer"
    Then I should have the cardCode "775533" in database
    And I should see "113"
    And I should see "775533"
    And I should see "8"

    When I follow "Supprimer"
    Then I should not see "113"
    And I should not see "775533"
    And I should see "Aucune carte trouvée"