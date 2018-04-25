Feature: Linkcard client
  In order to link my card
  As a client
  I need to be able to add my cardnumber

  Background:
    Given the following fixtures are loaded:
      | UserFixtures |
      | CardFixtures|

  @javascript
  Scenario: Link a card with fail
    Given I am logged as "macron@elysee.fr" with "test" password
    And I wait "2"
    When I click on "anchor-a-cards1"
    And I fill in "code_center" with "000"
    And I fill in "code_carte" with "000000"
    And I fill in "checksum" with "0"
    And I press "Rattacher une carte"
    Then I should see "Carte non rattachée !"

  @javascript
  Scenario: Link a card with success
    Given I am logged as "macron@elysee.fr" with "test" password
    And I wait "2"
    When I click on "anchor-a-cards1"
    When I fill in "code_center" with "123"
    And I fill in "code_carte" with "999999"
    And I fill in "checksum" with "6"
    And I press "Rattacher une carte"
    Then I should see "1239999996"