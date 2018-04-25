<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 12/04/18
 * Time: 16:15
 */

namespace App\Controller\Admin;


use App\Entity\Game;
use App\Form\GameCreationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 * @package App\Controller\Admin
 * @Route("/game")
 */
class GameController extends Controller
{
    /**
     * @Route("/list", name="admin_game_list")
     */
    public function list()
    {
        return $this->render('admin/game/list.html.twig');
    }

    /**
     * @Route("/new", name="admin_game_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $game = new Game();

        $form = $this->createForm(GameCreationFormType::class, $game);

        return $this->render('admin/game/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{id}", name="admin_game_view")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(Game $game)
    {
        return $this->render('admin/game/view.html.twig');
    }
}