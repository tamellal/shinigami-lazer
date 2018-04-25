Feature: SignUp user
  In order to be a client
  As a visitor
  I need to be able to signup

  @javascript
  Scenario: SignUp with success and fail
    Given I am on "/"
    When I click on "anchor-a-cards1"
    When I fill in "Prénom" with "Zinedine"
    And I fill in "Nom" with "Zidane"
    And I fill in "Pseudo" with "Zizou"
    And I fill in "Adresse" with "Santiago Bernabeu, Madrid"
    And I fill in "phone" with "0614070493"
    And I fill in "Date de naissance" with "1960-09-25"
    And I fill in "Adresse mail" with "zidane@madrid.es"
    And I fill in "Mot de passe" with "test"
    And I press "Inscription"
    Then I should have the contact "zidane@madrid.es" in database
    And I should see "zidane@madrid.es"

    When I follow "Déconnexion"
    And I wait "2"
    Then I should see "Bienvenue au Shinigami Laser !"

    Given I am on "/"
    When I click on "anchor-a-cards1"
    When I fill in "Prénom" with "Zinedine"
    And I fill in "Nom" with "Zidane"
    And I fill in "Pseudo" with "Zizou"
    And I fill in "Adresse" with "Santiago Bernabeu, Madrid"
    And I fill in "phone" with "0614070493"
    And I fill in "Date de naissance" with "1960-09-25"
    And I fill in "Adresse mail" with "zidane@madrid.es"
    And I fill in "Mot de passe" with "test"
    And I press "Inscription"
    Then I should see "Ce compte existe déjà !"
