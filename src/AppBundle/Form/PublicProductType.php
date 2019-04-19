<?php

namespace AppBundle\Form;

use AppBundle\Entity\PublicProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicProductType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('productnaam', EntityType::class, array(
            'class' => 'AppBundle:Product',
            'choice_value' => 'productnaam',
            'choice_label' => 'productnaam',
            'label' => 'Product'
        ))
        ->add('beschrijving', TextareaType::class)
        ->add('aantal', NumberType::class, array(
            'required' => false,
        ))
        ->add('prijs', MoneyType::class)
        ->add('verzendkosten', MoneyType::class)
        ->add('image', FileType::class, array(
            'label' => 'Afbeelding bestand'
        ))
      ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => PublicProduct::class,
    ));
  }
}