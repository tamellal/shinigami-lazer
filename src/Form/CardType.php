<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 30/03/18
 * Time: 15:19
 */

namespace App\Form;


use App\Entity\Club;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder

          # La liste des clubs
           ->add('club', EntityType::class, [
              'label'           => 'CODE_CENTER',
              'class'           => Club::class,
              'choice_label'    => 'code',
              'multiple'        => false,
              'expanded'        => false,
              'attr'            => [
                  'class'   => 'form-control'
              ]
          ])

          # Code
          ->add('code', TextType::class, [
              'label'       => 'CODE_CARTE',
              'required'    => true,
              'attr'        => [
                  'placeholder' => '000 000'
              ]
          ])

          # Champ Submit
          ->add('submit', SubmitType::class, [
              'attr' => ['class' => 'btn btn-info'],
              'label'   => 'Appliquer'
          ]);
    }

}