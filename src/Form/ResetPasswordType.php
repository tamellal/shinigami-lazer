<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 09/04/18
 * Time: 14:22
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            # Mot de passe
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => true,
                'attr'     => [
                    'placeholder' => "Saisissez votre nouveau mot de passe"
                ]
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info'],
                'label'     => 'valider'
            ]);
    }
}