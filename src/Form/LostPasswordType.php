<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 09/04/18
 * Time: 12:26
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LostPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            # Adresse mail
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail',
                'required' => true,
                'attr'     => [
                    'placeholder' => "Saisissez votre adresse mail"
                ]
            ])

            # Champ Submit
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info'],
                'label' => 'Continuer'
            ]);
    }
}