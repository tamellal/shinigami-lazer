<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 01/04/18
 * Time: 17:56
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            # Code du club
            ->add('code', NumberType::class, [
                'required' => true
            ])

            # Adresse du club
        ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => true
            ])

            # Bouton Submit
        ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-info'],
                'label'  => 'Valider'
            ]);
    }
}