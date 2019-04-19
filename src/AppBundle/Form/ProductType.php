<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('categorie', EntityType::class, array(
            'class' => 'AppBundle:Categorie',
            'choice_value' => 'naam',
            'choice_label' => 'naam',
        ))
        ->add('productnaam', TextType::class)
        ->add('inkoopprijs', MoneyType::class, [
            'label' => 'Inkoopprijs zonder korting'
        ])
        ->add('gewicht', NumberType::class, [
            'required' => false,
            'label' => 'Gewicht (niet verplicht)',
        ])
        ->add('adviesprijs', MoneyType::class, [
            'required' => false,
            'label' => 'Adviesprijs (niet verplicht)'
        ])
        ->add('minimaleVoorraad', NumberType::class, [
            'required' => false,
            'label' => 'Minimale voorraad (niet verplicht)'
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Product::class,
    ));
  }
}