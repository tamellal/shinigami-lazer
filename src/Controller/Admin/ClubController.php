<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 01/04/18
 * Time: 17:53
 */

namespace App\Controller\Admin;


use App\Entity\Club;
use App\Form\ClubType;
use App\Service\ClubManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller de gestion des cartes
 * @Route("/admin/club")
 */
class ClubController extends Controller
{

    /**
     * Page d'acceuil Club
     * @Route("/", name="admin_club_index", methods={"GET", "POST"})
     * @param ClubManager $clubManager
     * @return Response
     */
    public function indexAction(ClubManager $clubManager)
    {
        # Récupérartion de la liste des clubs
        $clubs = $clubManager->listClubs();

        # Affichage
        return $this->render('admin/club/index.html.twig', ['clubs'  => $clubs]);
    }

    /**
     * Creation du club
     * @Route("/create-club", name="admin_club_create", methods={"GET", "POST"})
     * @param Request $request
     * @param ClubManager $clubManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction (Request $request, ClubManager $clubManager)
    {
        # Création d'un club
        $club = new Club();

        # Création du formulaire de création de Club
        $form = $this->createForm(ClubType::class, $club);

        # Traitement des données POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            # Insertion en BDD
            $clubManager->createClub($club);

            # Alerte de création
            $this->addFlash('success', 'club.created_successfully');

            # Affichage
            return $this->redirectToRoute('admin_club_index');
        endif;

        return $this->render('admin/club/create.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * Mise à jour d'un club
     * @Route("/{id}/update", name="admin_club_update")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Club $club
     * @param ClubManager $clubManager
     * @return Response
     */
    public function updateAction(Request $request, Club $club, ClubManager $clubManager): Response
    {
        # Création du formulaire
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        # Si les données sont valides
        if ($form->isSubmitted() && $form->isValid()):

            # Insertion en BDD
           $this->getDoctrine()->getManager()->flush();

            # Alerte de mise à jour
           $this->addFlash('success', 'club.updated_successfully');

           # Affichage
           return $this->redirectToRoute('admin_club_index');
        endif;

        # Affichage du formulaire dans la vue
        return $this->render('admin/club/update.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Suppression d'un club
     * @Route("/{id}/delete", name="admin_club_delete")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Club $club
     * @param ClubManager $clubManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Club $club, ClubManager $clubManager)
    {
        # Suppression de la BDD
        $clubManager->deleteClub($club);

        # Alerte de suppression
        $this->addFlash('success', 'club.deleted_successfully');

        #Affichage
        return $this->redirectToRoute("admin_club_index");
    }

}