<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 02/04/18
 * Time: 20:05
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public const MACRON_EMAIL = 'macron@elysee.fr';

    public function load(ObjectManager $manager)
    {

     /**
      * Données pour les tests Behat
      */

        $user = new User();
        $user->setFirstname('Emmanuel');
        $user->setLastName('Macron');
        $user->setAddress('Palais de l\'Élysée, Paris');
        $user->setPhone('0142928100');
        $user->setBirthDate(new \DateTime('now'));
        $user->setNickName('Manu');
        $user->setEmail(self::MACRON_EMAIL);
        $user->setLastConnexionDate(new \DateTime('now'));
        $user->setSignUpDate(new \DateTime('now'));
        $user->setLastModificationDate(new \DateTime('now'));
        $user->setRoles('ROLE_MEMBER');
        # Gestion du mot de passe
        $password = $this->container->get('security.password_encoder')->encodePassword($user, 'test');
        $user->setPassword($password);

        $manager->persist($user);

      /**
       * Données générales à base du faker
       */
      $faker = Factory::create('fr_FR');

        for ($i=1; $i<=10; $i++)
        {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setAddress($faker->address);
            $user->setPhone($faker->phoneNumber);
            $user->setBirthDate($faker->dateTime($max = 'now'));
            $user->setNickName($faker->userName);
            $user->setEmail($faker->email);
            $user->setLastConnexionDate($faker->dateTimeBetween('-2 years', 'now'));
            $user->setSignUpDate($faker->dateTimeBetween('-5 years', '-3 years'));
            $user->setLastModificationDate($faker->dateTimeBetween('-3 years', 'now'));
            $user->setRoles('ROLE_MEMBER');
            # Gestion du mot de passe
            $password = $this->container->get('security.password_encoder')->encodePassword($user, 'test');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}