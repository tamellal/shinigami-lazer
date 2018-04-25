Feature: Login user
  In order to see my profile
  As a visitor
  I need to be able to login

  Background:
    Given the following fixtures are loaded:
      | UserFixtures |

  @javascript
  Scenario: Login with success
    Given I am on "/"
    When I click on "anchor-a-cards2"
    And I fill in "_username" with "macron@elysee.fr"
    And I fill in "_password" with "test"
    And I press "Connexion"
    And I wait "2"
    Then I should see "Profil"

    When I click on "anchor-a-cards1"
    Then I should see "Emmanuel"

  @javascript
  Scenario: Login with fail
    Given I am on "/"
    When I click on "anchor-a-cards2"
    And I fill in "_username" with "emmanuel@elysee.fr"
    And I fill in "_password" with "test"
    And I press "Connexion"
    And I wait "2"
    Then I should not see "Profil"