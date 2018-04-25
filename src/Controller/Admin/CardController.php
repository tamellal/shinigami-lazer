<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 30/03/18
 * Time: 15:15
 */

namespace App\Controller\Admin;


use App\Entity\Card;
use App\Form\CardType;
use App\Service\CardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;


/**
 * Controller de gestion des cartes
 * @Route("/admin/card")
 */
class CardController extends Controller
{

    /**
     * Page d'accueil Cartes
     * @Route("/", name="admin_card_index", methods={"GET", "POST"})
     * @param CardManager $cardManager
     * @return Response
     */
    public function indexAction(CardManager $cardManager)
    {
        # Récupération de la liste des cartes
        $cards = $cardManager->listCards();

        # Affichage
        return $this->render('admin/card/index.html.twig', ['cards' => $cards]);
    }

    /**
     * Créer une carte
     * @Route ("/create", name="admin_card_create", methods={"GET", "POST"})
     * @param Request $request
     * @param Registry $workflows
     * @param CardManager $cardManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request, Registry $workflows, CardManager $cardManager)
    {
        # Création d'une nouvelle carte
        $card = new Card();

        # Création du formulaire de création de carte
        $form = $this->createForm(CardType::class, $card);

        # Traitement des données POST
        $form->handleRequest($request);

        # Vérification des données du formulaire

        if ($form->isSubmitted() && $form->isValid()):

            $cardManager->createCard($card);
            $workflow = $workflows->get($card);
            $workflow->apply($card, 'to_wait');
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'flash.card.created');
            return $this->redirectToRoute('admin_card_index');

        endif;

        # Affichage du formulaire dans le vue
        return $this->render('admin/card/create.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * Mettre à jour la carte
     * @Route("/{id}/update", name="admin_card_update")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Card $card
     * @param CardManager $cardManager
     * @return Response
     */
    public function updateAction(Request $request, Card $card, CardManager $cardManager): Response
    {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            # Mise à jour du checkSum
            $card->setCheckSum($cardManager->generateCheckSum($card->getCode(),$card->getClub()->getCode()));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute("admin_card_index");

        endif;

        # Affichage du formulaire dans le vue
        return $this->render('admin/card/update.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * Supprimer une carte
     * @Route ("/{id}/delete-card", name="admin_card_delete", methods={"GET", "POST"})
     * @param Request $request
     * @param Card $card
     * @param CardManager $cardManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Card $card, CardManager $cardManager)
    {
        $cardManager->deleteCard($card);

        $this->addFlash('success', 'carte supprimée avec succés');

        return $this->redirectToRoute("admin_card_index");
    }
}