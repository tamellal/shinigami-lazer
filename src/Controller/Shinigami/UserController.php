<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 29/03/18
 * Time: 10:01
 */

namespace App\Controller\Shinigami;


use App\Entity\User;
use App\Form\CardNumber;
use App\Service\CardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

class UserController extends Controller
{

    /**
     *
     * @Route ("/profile", name="user_profile", methods={"GET", "POST"})
     */
    public function read()
    {

        # Récupération de l'utilisateur
        $user = $this->getUser();


        # Affichage dans la vue
        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    /**
     *
     * @Route ("/linkcard", name="user_linkcard", methods={"GET", "POST"})
     * @param Request $request
     * @param CardManager $cardManager
     * @param Registry $workflows
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function linkCard(Request $request, CardManager $cardManager, Registry $workflows)
    {

        # Récupération de l'utilisateur
        $user = $this->getUser();

        # Vérifier que la carte est valide (création + checkSum)
        if ($cardManager->isValid($request->request->get('code_center'),
                              $request->request->get('code_carte'),
                              $request->request->get('checksum'))) {
            # Rattacher la carte à l'utilisateur
            $card = $cardManager->findByCodeCarte($request->request->get('code_carte'));
            $user->setCard($card);
            $card->setUser($user);

            // Passage à l'état suivant dans le workflow
            $workflow = $workflows->get($card);
            $workflow->apply($card, 'to_link');

            # Mise à jour de la BDD
            $this->getDoctrine()->getManager()->flush();

            # Renvoyer un message de succés
            $this->addFlash('success', 'flash.card.linksuccess');

        }
        else {
            # Renvoyer un message d'erreur
            $this->addFlash('warning', 'flash.card.linkfailed');
        }

        # Affichage dans la vue
        return $this->redirectToRoute('user_profile');

    }

}