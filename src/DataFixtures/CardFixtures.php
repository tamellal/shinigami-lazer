<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 03/04/18
 * Time: 11:57
 */

namespace App\DataFixtures;


use App\Entity\Card;
use App\Entity\Club;
use App\Service\CardManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Workflow\Registry;

class CardFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        /**
         * Données pour les tests Behat
         */
          # Création du club
          $club = new Club();
          $club->setCode(123);
          $club->setAddress('Paris 13');
          $manager->persist($club);

          $card = new Card();
          $card->setCode(999999);
          $card->setClub($club);
          $this->container->get(CardManager::class)->createCard($card);
          $this->container->get('workflow.card_linking')->apply($card, 'to_wait');
          $manager->flush();

        /**
         * Données générales à base du faker
         */
//        $faker = Factory::create('fr_FR');
//
//        for ($i=1; $i<=10; $i++)
//        {
//            $card = new Card();
//            $card->setCode($faker->numberBetween(100000, 999999));
//            $manager->persist($card);
//        }
//
//        $manager->flush();
    }

}