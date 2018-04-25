<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 19/04/18
 * Time: 15:29
 */

namespace App\Controller\Security;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var RouterInterface $router
     */
    private $router;


    /**
     * AuthenticationHandler constructor.
     */
    public function __construct(SerializerInterface $serializer, RouterInterface $router)
    {
        // récupération du router et du serializer

        $this->serializer = $serializer;
        $this->router = $router;
    }


    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()){

            // data à renvoyer en json
            $array = array('success' => false, 'message' => $exception->getMessage());

            return new JsonResponse($array);
        }
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest()){

            // serialiaztion de l'utilisateur
            $user = $token->getUser();

            $jsonContent = $this->serializer->serialize($user, 'json', array('attributes' => array('firstname', 'lastname')));

            $routeAdmin = ($user->getRoles() === array('ROLE_ADMIN')) ? $this->router->generate('admin_index') : null;

            // data à renvoyer en json
            $array = array('success' => true, 'user' => $jsonContent, 'url' => $routeAdmin);

            return new JsonResponse($array);
        }
    }
}