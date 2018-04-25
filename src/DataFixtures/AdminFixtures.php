<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 17/04/18
 * Time: 14:39
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class AdminFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public const ADMIN_EMAIL = 'admin@shinigami-laser.com';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setFirstname('Admin');
        $user->setLastname('Admin');
        $user->setEmail(self::ADMIN_EMAIL);
        $user->setNickname('ShinigAdmin');
        $user->setAddress('Dans le labyrinthe');
        $user->setBirthdate($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null));
        # Gestion du mot de passe
        $password = $this->container->get('security.password_encoder')->encodePassword($user, 'test');
        $user->setPassword($password);
        $user->setPhone($faker->phoneNumber);
        $user->setRoles('ROLE_ADMIN');

        $manager->persist($user);
        $manager->flush();
    }
}