Feature: Lost Password
  In order to rest my password
  As a visitor
  I need to be able to change my password

  Background:
    Given the following fixtures are loaded:
      | UserFixtures |


  Scenario: Lost Password
    Given I am on "/login"
    When I follow "Mot de passe oublié"
    Then I should see "Mot de passe oublié"

    When I fill in "Adresse mail" with "macron@elysee.fr"
    And I press "Continuer"
    Then I should see "Mail de rénitialisation de mot de passse envoyé"

  Scenario: Reset Password
    Given I am on "/rest-password/c593b1f401c41b315e291dc425c65826"
    Then I should see "Mot de passe oublié"