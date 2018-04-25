<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 29/03/18
 * Time: 12:11
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          # Prénom
          ->add('firstName', TextType::class, [
              'label' => 'Prénom',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre Prénom"
              ]
          ])

          # Nom
          ->add('lastName', TextType::class, [
              'label' => 'Nom',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre Nom"
              ]
          ])

          # Date de naissance
          ->add('birthDate', BirthdayType::class, array(
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',
              'label' => 'Date de naissance'

            ))

          # Adresse
          ->add('address', TextType::class, [
              'label' => 'Adresse',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre Adress"
              ]
          ])

          # Numéro de téléphone
          ->add('phone', TelType::class, [
              'label' => 'Numéro de téléphone',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre Adress"
              ]
          ])

          # Pseudo
          ->add('nickName', TextType::class, [
              'label' => 'Pseudo',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre Pseudo"
              ]
          ])

          # Adresse mail
          ->add('email', EmailType::class, [
              'label' => 'Adresse mail',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre adresse mail"
              ]
          ])

          # Mot de passe
          ->add('password', PasswordType::class, [
              'label' => 'Mot de passe',
              'required' => true,
              'attr'     => [
                  'placeholder' => "Saisissez votre adresse email"
              ]
          ])

          # Champ Submit
        ->add('submit', SubmitType::class, [
            'label' => 'Inscription',
             'attr' => ['class' => 'btn btn-info']
          ]);
    }
}