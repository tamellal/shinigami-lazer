<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminEditUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('label' => 'user.firstname'))
            ->add('lastname', TextType::class, array('label' => 'user.lastname'))
            ->add('nickname', TextType::class, array('label' => 'user.nickname'))
            ->add('address', TextType::class, array('label' => 'user.address'))
            ->add('birthdate', BirthdayType::class, array('widget' => 'single_text', 'label' => 'user.birthdate'))
            ->add('email', EmailType::class, array('label' => 'user.email'))
            ->add('phone', TextType::class, array('label' => 'user.phone'))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-info'),
                'label'=> 'btn.save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
