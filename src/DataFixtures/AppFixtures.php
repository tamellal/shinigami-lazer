<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

//        for ($i = 1 ; $i < 200 ; $i++) {
//
//            if ($i == 1){
//                $user = new User();
//                $user->setFirstname('Admin');
//                $user->setLastname('Admin');
//                $user->setEmail('admin@shinigami-laser.com');
//                $user->setNickname('ShinigAdmin');
//                $user->setAddress('Dans le labyrinthe');
//                $user->setBirthdate($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null));
//                $user->setPassword('$2y$13$Hq3byz58MGZymiS39GnG0.6nZvWNi2OJ37fLh6b9u.6HBWW3zKG..');
//                $user->setPhone($faker->phoneNumber);
//                $user->setRoles('ROLE_ADMIN');
//
//                $manager->persist($user);
//            }else {
//                $user = new User();
//                $user->setFirstname($faker->firstName);
//                $user->setLastname($faker->lastName);
//                $email = str_replace(' ', '', strtolower($user->getFirstname() . $user->getLastname() . '@' . $faker->freeEmailDomain));
//                $user->setEmail($email);
//                $user->setNickname($faker->userName . $i);
//                $user->setAddress($faker->address);
//                $user->setBirthdate($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null));
//                $user->setPassword('$2y$13$Hq3byz58MGZymiS39GnG0.6nZvWNi2OJ37fLh6b9u.6HBWW3zKG..');
//                $user->setPhone($faker->phoneNumber);
//                $user->setRoles('ROLE_MEMBER');
//
//                $manager->persist($user);
//            }
//        }

        $manager->flush();
    }
}
