<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 18/04/18
 * Time: 17:29
 */

namespace App\Tests\Controller\Admin;


use App\DataFixtures\AdminFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
    /** @var Client null */
    private $client = null;

    public function setUp ()
    {
        $this->client = static::createClient();
        $application = new  Application($this->client->getKernel());
        # Pour ne pas sortir du test à chaque fois
        $application->setAutoExit(false);
        $application->run(new StringInput('doctrine:fixtures:load --env=test'));
    }


    public function testAdminHomePage()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/admin');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h1')->count());
        $this->assertEquals('ShinigAdmin', $crawler->filter('h1')->text());

    }


    public function testAdminDisplayUsersList()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/admin/users/list');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h1')->count());
        $this->assertEquals('Liste des clients', $crawler->filter('h1')->text());
        $this->assertGreaterThan(1, $crawler->filter('li')->count());

    }

    public function testAdminDisplayUserInformations()
    {
        $this->logIn();
        $admin = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => AdminFixtures::ADMIN_EMAIL]);
        $editUrl = sprintf('/admin/users/%s', $admin->getId());
        $crawler = $this->client->request('GET', $editUrl);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('Informations client', $crawler->filter('h3')->text());

    }

    public function testAdminUpdateUserInformations()
    {
        $newFirstName = 'Emmanuel Jean-Michel Frédéric';

        $this->logIn();
        /** @var User $user */
        $user = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => UserFixtures::MACRON_EMAIL]);
        $editUrl = sprintf('/admin/users/%s', $user->getId());
        $crawler = $this->client->request('GET', $editUrl);
        $form = $crawler->selectButton('Enregistrer')->form([
            'admin_edit_user_form[firstname]' => $newFirstName,
        ]);
        $this->client->submit($form);

        /** @var User $updatedUser */
        $updatedUser = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => UserFixtures::MACRON_EMAIL]);
        $this->assertSame($newFirstName, $updatedUser->getFirstname());
    }

    public function testAdminDeleteUser()
    {
        $this->logIn();
        /** @var User $user */
        $user = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => UserFixtures::MACRON_EMAIL]);
        $editUrl = sprintf('/admin/users/%s', $user->getId());
        $crawler = $this->client->request('GET', $editUrl);
        $this->client->submit($crawler->filter('#delete-user')->form());


        /** @var User $deletedUser */
        $deletedUser = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => UserFixtures::MACRON_EMAIL]);
        $this->assertNull($deletedUser);
    }

    public function testAdminSearchUserFound()
    {
        $this->logIn();
        /** @var User $user */
        $user = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => UserFixtures::MACRON_EMAIL]);
        $editUrl = sprintf('/admin/search?q=%s', $user->getLastname());
        $crawler = $this->client->request('GET', $editUrl);
        $this->assertEquals('Emmanuel', $crawler->filter('td')->text());
    }

    public function testAdminSearchUserNotFound()
    {
        $this->logIn();
        /** @var User $user */
        $user = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => UserFixtures::MACRON_EMAIL]);
        $editUrl = sprintf('/admin/search?q=%s', $user->getLastname());
        $crawler = $this->client->request('GET', '/admin/search?q=toto');
        $this->assertEquals('Aucun client enregistré', $crawler->filter('td')->text());
    }


    private function logIn()
    {
        /** @var Session $session */
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $user = $this->client->getContainer()->get('doctrine')
            ->getRepository(User::class)->findOneBy(['email' => 'admin@shinigami-laser.com']);

        $token = new UsernamePasswordToken($user, null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

}