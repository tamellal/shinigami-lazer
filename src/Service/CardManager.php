<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 03/04/18
 * Time: 16:29
 */

namespace App\Service;


use App\Entity\Card;
use Doctrine\Common\Persistence\ObjectManager;

class CardManager
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retourner la liste des cartes
     */
    public function listCards()
    {
        return $this->em->getRepository(Card::class)->findAll();
    }

    /**
     * Création d'une carte
     * @param Card $card
     */
    public function createCard(Card $card)
    {
        $card->setCheckSum($this->generateCheckSum($card->getCode(),$card->getClub()->getCode()));
        $card->setNumber();

        # Insertion en BDD
        $this->em->persist($card);
        $this->em->flush();
    }

    /**
     * Suppression d'une carte
     * @param Card $card
     */
    public function deleteCard(Card $card)
    {
        $this->em->remove($card);
        $this->em->flush();
    }


    /**
     * Génerer le checkSum
     * @param $codeCenter
     * @param $codeCarte
     * @return int
     */
    public function generateCheckSum($codeCenter, $codeCarte)
    {
        return ($this->sum($codeCenter)+$this->sum($codeCarte))%9;
    }

    /**
     * Calculer la somme des chiffres d'un nombre
     * @param $code
     * @return int
     */
    private function sum($code):int
    {
      $loop = true;
      $sum = 0;

      while ($loop){
          # Recupérer le premier chiffre
          $sum += $code % 10;
          # Récupérer le reste des chiffres
          $code = (int)($code/10);

          # Vérifier s'il ne reste plus de chiffres à récupérer
          if ($code === 0) {
              $loop = false;
          }

      }
      return $sum;
    }

    /**
     * Vérifier si la carte est valide
     * @param int $codeCenter
     * @param int $codeCarte
     * @param int $checkSum
     * @return bool
     */
    public function isValid (int $codeCenter, int $codeCarte, int $checkSum)
    {
        # Vérifier si la carte a été créée et le checkSum est valide
        if ((null == $this->findByCodeCarte($codeCarte)) ||
             ($checkSum != $this->generateCheckSum($codeCenter, $codeCarte))){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Chercher une carte
     * @param int $codeCarte
     * @return Card|null
     */
    public function findByCodeCarte (int $codeCarte):?Card
    {
        return $this->em->getRepository(Card::class)->findOneByCodeCarte($codeCarte);
    }
}