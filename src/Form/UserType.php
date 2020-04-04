<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('username', EmailType::class)
        ->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options' => array('label' => 'Wachtwoord'),
            'second_options' => array('label' => 'Wachtwoord herhalen'),
        ));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => User::class,
    ));
  }
}