<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 29/03/18
 * Time: 13:07
 */

namespace App\Controller\Admin;


use App\Entity\Card;
use App\Entity\Club;
use App\Entity\User;
use App\Form\AdminEditUserFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @Route("/admin")
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * Affiche la page générale d'administration
     *
     * @Route("", name="admin_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $countUsers = count($this->getDoctrine()->getRepository(User::class)->findAll());

        $countCards = $this->getDoctrine()->getRepository(Card::class)->count(['currentPlace' => 'waiting']);

        $countClubs = count($this->getDoctrine()->getRepository(Club::class)->findAll());

        return $this->render('admin/index.html.twig', compact('countUsers','countCards', 'countClubs'));
    }

    /**
     * Affiche la liste de tous les clients
     *
     * @Route("/users/list", name="admin_list_user")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list()
    {
        // on récupère tous les utilisateurs pour les renvoyer dans la vue
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/user/list.html.twig', compact('users'));
    }

    /**
     * Edition des informations d'un utilisateur
     *
     * @Route("/users/{id}", name="admin_edit_user")
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, User $user)
    {
        // on créé le formulaire grâce à la classe adéquate, puis soumission et vérification
        $form = $this->createForm(AdminEditUserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // on set la date de dernière connexion à l'instant présent, puis on enregistre en BDD
            $user->setLastModificationDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            // On notifie via message flash du succès de l'opération
            $this->addFlash('success', 'flash.modif.saved');
        }

        return $this->render('admin/user/edit_user.html.twig', array('form' => $form->createView(), 'user' => $user));

    }

    /**
     * Suppression d'un utilisateur
     *
     * @Route("users/delete/{id}", name="admin_delete_user")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {

        // on récupère l'utilisateur en DB en fonction de son id
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        // si aucun utilisateur n'a été trouvé, on redirige vers la liste des clients avec un message de warning
        if (!$user) {
            $this->addFlash('warning', 'flash.user.not.found');
            return $this->redirectToRoute('admin_list_user', array(), 301);
        }

        // si l'utilisateur a été trouvé, on le supprime et on renvoie vers l'index avec un message de success
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'flash.user.deleted');
        return $this->redirectToRoute('admin_list_user');

    }

    /**
     * Recherche d'un utilisateur
     *
     * @Route("/search", name="admin_search_user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $query = $request->query;

        if ($query->has('q')) {
            $users = $this->getDoctrine()->getRepository(User::class)->findBy(['lastname' => $query->get('q')]);
        }
        if ($query->has('n')){
            $users = $this->getDoctrine()->getRepository(User::class)->findOneByCardNumber($query->get('n'));
            dump($users);
        }

        if (empty($users)){
            $this->addFlash('warning', 'flash.user.not.found');
        }

        return $this->render('admin/user/list.html.twig', compact('users'));
    }
}
