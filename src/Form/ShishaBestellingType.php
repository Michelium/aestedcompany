<?php

namespace App\Form;

use App\Entity\Bestelling;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShishaBestellingType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('smaak', EntityType::class, array(
            'label' => 'Smaak',
            'class' => 'App\Entity\Product',
            'choice_value' => 'smaak',
            'choice_label' => 'smaak',
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('u')
                  ->where('u.shishapen = true')
                  ->orderBy('u.populariteit', 'ASC');
            },
        ))
        ->add('besteldaantal', NumberType::class, array(
            'label' => 'Aantal',
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('inkoopprijs', MoneyType::class, array(
            'attr' => array('autocomplete' => 'off')
        ));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Bestelling::class,
    ));
  }
}