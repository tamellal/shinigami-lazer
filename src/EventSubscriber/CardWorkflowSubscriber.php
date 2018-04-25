<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class CardWorkflowSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer $mailer
     */
    private $mailer;

    /**
     * CardWorkflowSubscriber constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public static function getSubscribedEvents()
    {
        return [
           'workflow.card_linking.transition.to_link' => 'onCardLinking',
        ];
    }

    public function onCardLinking(Event $event)
    {
        $card = $event->getSubject();
        $user = $card->getUser();

        $message = (new \Swift_Message('Merci d\'avoir lié votre carte !'))
            ->setFrom('noreply@shinigami-laser.com')
            ->setTo($user->getEmail())
            ->setBody("Cher  " . $user->getFirstname() . " ! Merci d'avoir lié votre carte ! Vous pourrez retrouver maintenant toutes vos informations sur votre profil !");

        $this->mailer->send($message);dump($card);dump($user);
    }
}
