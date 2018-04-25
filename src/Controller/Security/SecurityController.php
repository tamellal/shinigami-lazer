<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 29/03/18
 * Time: 11:46
 */

namespace App\Controller\Security;


use App\Entity\User;
use App\Form\LostPasswordType;
use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Service\UserManager;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * Inscrire un utilisateur
     * @Route ("/signup", name="security_signup", methods={"GET", "POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        # Creation d'un nouvel utilisateur
        $user = new User();
        $user->setRoles('ROLE_MEMBER');

        # Création du formulaire d'inscription
        $form = $this->createForm(UserType::class, $user);

        # Récupération des données POST
        $form->handleRequest($request);

        # Vérification du formulaire
        if ($form->isSubmitted() && $form->isValid()):

            # Gestion du mot de passe
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            # Insertion en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            #Envoyer un mail de confirmation
            $message = (new \Swift_Message('Confirmation d\'inscription'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/registration.html.twig',
                        array('name' => $user->getFirstname())
                    ),
                    'text/html'
                );

            $mailer->send($message);

            # Se connecter aprés l'inscription
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            # Redirection vers la page de connexion
            return $this->redirect('profile?signup=success');
        endif;

        # Affichage du formulaire dans la vue
        return $this->render('security/signup.html.twig', [
            'form'  => $form->createView()
        ]);

    }

    /**
     * Connecter un utilisateur
     * @Route ("/login", name="security_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
        {
            if (!$request->isMethod('post')){
                return $this->redirectToRoute('index');
            }
        }

    /**
     * Mot de passe oublié
     * @Route ("/lost-password", name="security_lostPassword", methods={"GET", "POST"})
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @param Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lostPassword(Request $request, AuthenticationUtils $authenticationUtils, \Swift_Mailer $mailer, UserManager $userManager)
    {
        # Dernier email saisie par l'utilisateur.
        $lastEmail = $authenticationUtils->getLastUsername();

        # Création d'un formulaire d'oubli de mot de passe
        $form = $this->createForm(LostPasswordType::class);

        # Récupération des données POST
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            # Récupérer l'utilisateur en BDD
            $user = $userManager->findOneByEmail($form->get('email')->getData());

            # Vérifier si l'utilisateur est inscrit
            if (null !== $user) {

              # Création du token
              $token = md5(uniqid());
              $user->setToken($token);

                # Mise à jour de la BDD
                $em = $this->getDoctrine()->getManager();
                $em->flush();

              #Envoyer un mail de reset de mot de passe
              $message = (new \Swift_Message('Réinitialisation de mot de passe'))
                    ->setFrom('send@example.com')
                    ->setTo('recipient@example.com')
                    ->setBody(
                        $this->render(
                            'emails/resetPassword.html.twig', [
                                'user'  => $user
                        ]),
                        'text/html'
                    );

                $mailer->send($message);

                $this->addFlash('success', 'flash.password.mail.sent');

            }

        }
        # Affichage du fomulaire
        return $this->render('security/lostPassword.html.twig', [
            'form'  => $form->createView()

        ]);
    }

    /**
     * Réinitialiser le mot de passe
     * @Route ("/rest-password/{token}", name="security-resetPassword", methods={"GET", "POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param $token
     * @param UserManager $userManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetPassword (Request $request, UserPasswordEncoderInterface $passwordEncoder, $token, UserManager $userManager)
    {

        # Récupération de l'utilisateur
        $user = $userManager->findOneByToken($token);

        # Création du formulaire de changement de mot de passe
        $form = $this->createForm(ResetPasswordType::class);

        #Récupération des données POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            # Gestion du mot de passe
            $password = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);

            # Mise à jour de la BDD
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            # Se connecter aprés l'inscription
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            # Redirection vers la page de connexion
            return $this->redirectToRoute('user_profile');
        }

        # Affichage du formulaire
        return $this->render('security/resetPassword.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}