<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bestelling;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BestellingBezorgType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('extraInfo', TextareaType::class, [
            'attr' => ['autocomplete' => 'off'],
            'required' => false,
            'label' => 'Extra informatie (niet verplicht)'
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Bestelling::class,
    ));
  }
}