<?php

namespace AppBundle\Form;

use AppBundle\Entity\Opmerking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpmerkingType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('opmerking', TextareaType::class, array(
            'label' => 'Klacht of opmerking:'
        ));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Opmerking::class,
    ));
  }
}