<?php

use App\Entity\User;
use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 12/04/18
 * Time: 15:19
 */

class SecurityContext extends RawMinkContext
{
    use KernelDictionary;

    /**
     * @When I wait :arg1
     */
    public function iWait($duration)
    {
        $this->getSession()->wait($duration * 1000);
    }

    /**
     * @Then I should have the contact :arg1 in database
     */
    public function iShouldHaveTheContactInDatabase($email)
    {
        if (null === $this->getContainer()->get('doctrine')->getRepository(User::class)->findOneByEmail($email)){
            throw new \Exception('Le contact n\'a pas été ajouté');
        }
    }

    /**
     * @Given I am logged as :email with :password password
     */
    public function iAmLoggedAsWithPassword($email, $password)
    {
        if (!$user = $this->getUserRepository()->findOneByEmail($email)) {
            throw new \Exception(sprintf('Admin %s not found', $email));
        }

        $this->logAs($user, $password);
    }

    /**
     * @When I click on :link
     */
    public function iClickOn($link)
    {
        $page = $this->getSession()->getPage();
        $page->findById($link)->click();

        return;
    }



    private function logAs(UserInterface $user, $password): void
    {
        //$driver = $this->getSession()->getDriver();
        //$session = $this->getContainer()->get('session');
        $this->visitPath('/');

        //if ($driver instanceof Selenium2Driver) {
            $page = $this->getSession()->getPage();

            $page->findById('anchor-a-cards2')->click();
            $page->findField('_username')->setValue($user->getUsername());
            $page->findField('_password')->setValue($password);
            $page->findButton('Connexion')->press();

            return;
        //}

        /*$token = new UsernamePasswordToken($user, null, 'main_context', $user->getRoles());
        $session->set('_security_main_context', serialize($token));
        $session->save();


        $client = $driver->getClient();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
        $this->getSession()->setCookie($session->getName(), $session->getId());*/
    }

    private function getUserRepository(): UserRepository
    {
        return $this->getContainer()->get('doctrine')->getRepository(User::class);

    }

}