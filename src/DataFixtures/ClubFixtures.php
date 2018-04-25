<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 03/04/18
 * Time: 14:29
 */

namespace App\DataFixtures;


use App\Entity\Club;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ClubFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        /**
         * Données pour les tests Behat
         */
        $club = new Club();
        $club->setCode(113);
        $club->setAddress('Paris 13');
        $manager->persist($club);

        /**
         * Données générales à base du faker
         */
        $faker = Factory::create('fr_FR');

        for ($i=1; $i<=5; $i++)
        {
            $club = new Club();
            $club->setCode($faker->numberBetween(200, 999));
            $club->setAddress($faker->address);
            $manager->persist($club);
        }
        $manager->flush();
    }
}