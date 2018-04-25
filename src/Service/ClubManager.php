<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 04/04/18
 * Time: 09:32
 */

namespace App\Service;


use App\Entity\Club;
use Doctrine\Common\Persistence\ObjectManager;

class ClubManager
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retourner la liste des clubs
     */
    public function listClubs()
    {
        # Récupération de la liste des clubs
        return $this->em->getRepository(Club::class)->findAll();
    }

    /**
     * Création d'un club
     * @param Club $club
     */
    public function createClub(Club $club)
    {
        # Insertion en BDD
        $this->em->persist($club);
        $this->em->flush();
    }

    /**
     * Supression d'un club
     * @param $club
     */
    public function deleteClub($club)
    {
        # Supprimer le club
        $this->em->remove($club);
        $this->em->flush();
    }

}