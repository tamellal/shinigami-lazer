<?php

namespace App\Twig;

use App\Entity\User;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('concatenateCardNumber', [$this, 'concatenateCardNumber']),
            new TwigFunction('generateQRCode', [$this, 'generateQRCode']),
        ];
    }

    /**
     * Fonction permettant de concaténer le numéro de la carte de fidélité
     *
     * @param User $user
     * @return null|int
     */
    public function concatenateCardNumber(User $user)
    {
        // on vérifie si le client a bien une carte liée à son compte
        $card = $user->getCard();

        if (is_null($card)) {
            // si pas de carte, on retourne null
            return null;
        }

        // s'il y a une carte, on concaténe le code
        return $card->getClub()->getCode() . $card->getCode() . $card->getCheckSum();
    }

    /**
     * Permet de générer un QRCode en fonction du numéro de carte de fidélité
     *
     * @param User $user
     * @return mixed
     */
    public function generateQRCode(User $user)
    {

        // on concatène le code de la carte pour retrouver le numéro de carte
        $data = $this->concatenateCardNumber($user);

        // s'il y a un numéro de carte, on génère le QRCode
        if (!is_null($data)) {
            $options = new QROptions([
                'version' => 1,
                'outputType' => QRCode::OUTPUT_IMAGE_JPG,
                'eccLevel' => QRCode::ECC_H,
            ]);

            // invoke a fresh QRCode instance
            $qrcode = new QRCode($options);

            return $qrcode->render($data);
        }
    }
}
