<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 08/04/18
 * Time: 15:40
 */

namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;

class UserManager extends AbstractType
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * Vérifier si l'utilisateur est enregistré
     * @param $email
     * @return bool
     */
    public function isSignedUp ($email)
    {
        if (null === $this->findOneByEmail($email)){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Retourner l'utilisateur correspondant à l'adresse mail
     * @param $email
     * @return mixed
     */
    public function findOneByEmail ($email)
    {
        return $this->em->getRepository(User::class)->findOneByEmail($email);
    }

    /**
     * Retourner l'utilisateur correspondant au Token
     * @param $token
     * @return User|null
     */
    public function findOneByToken($token)
    {
        return $this->em->getRepository(User::class)->findOneByToken($token);
    }
}