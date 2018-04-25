<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 11/04/18
 * Time: 14:24
 */

namespace App\Controller\Shinigami;


use App\Service\ClubManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends Controller
{
    /**
     * Liste des clubs
     * @Route("/clubs", name="club_index", methods={"GET", "POST"})
     * @param ClubManager $clubManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(ClubManager $clubManager)
    {
        # Récupérartion de la liste des clubs
        $clubs = $clubManager->listClubs();

        # Affichage
        return $this->render('club/index.html.twig', ['clubs'  => $clubs]);
    }
}