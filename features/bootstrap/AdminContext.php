<?php

use App\Entity\Card;
use App\Entity\Club;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 17/04/18
 * Time: 16:31
 */

class AdminContext extends RawMinkContext
{
    use KernelDictionary;

    /**
     * @Then I should have the clubCode :clubCode in database
     */
    public function iShouldHaveTheClubInDatabase($clubCode)
    {
        if (null === $this->getContainer()->get('doctrine')->getRepository(Club::class)->findOneBy(['code'=> $clubCode])){
            throw new \Exception('Le club n\'a pas été ajouté');
        }
    }

    /**
     * @Then I should have the cardCode :cardCode in database
     */
    public function iShouldHaveTheCodecardInDatabase($cardCode)
    {
        if (null === $this->getContainer()->get('doctrine')->getRepository(Card::class)->findOneBy(['code'=> $cardCode])){
            throw new \Exception('La carte n\'a pas été ajoutée');
        }
    }


}