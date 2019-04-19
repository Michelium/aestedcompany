<?php

namespace AppBundle\Form;

use AppBundle\Entity\Artikel;
use AppBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtikelType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('naam', TextType::class)
        ->add('categorie', EntityType::class, array(
            'class' => 'AppBundle:Categorie',
            'choice_value' => 'naam',
            'choice_label' => 'naam',
        ))
        ->add('inkoopprijs', MoneyType::class, [
            'label' => 'Inkoopprijs (niet verplicht)',
            'required' => false,
        ])
        ->add('minimaleVerkoopprijs', MoneyType::class, [
            'label' => 'Minimale verkoopprijs (niet verplicht)',
            'required' => false,
        ])
        ->add('gewicht', NumberType::class, [
            'label' => 'Gewicht (niet verplicht)',
            'required' => false,
        ])
        ->add('adviesprijs', MoneyType::class, [
            'label' => 'Adviesprijs (niet verplicht)',
            'required' => false,
        ])
        ->add('minimaleVoorraad', NumberType::class, [
            'label' => 'Minimale voorraad (niet verplicht)',
            'required' => false,
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Artikel::class,
    ));
  }
}