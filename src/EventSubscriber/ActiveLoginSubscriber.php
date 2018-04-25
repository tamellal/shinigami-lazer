<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class ActiveLoginSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * LoginSubscriber constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        $date = new \DateTime();

        $user->setLastConnexionDate($date);

        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
           'security.interactive_login' => 'onSecurityInteractiveLogin',
        ];
    }
}
