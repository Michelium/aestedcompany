<?php

namespace AppBundle\Form;

use AppBundle\Entity\Klacht;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KlachtType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('klachtText', TextareaType::class, array(
            'label' => 'Klacht of opmerking:'
        ));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Klacht::class,
    ));
  }
}