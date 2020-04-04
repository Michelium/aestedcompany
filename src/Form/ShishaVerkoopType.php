<?php

namespace App\Form;

use App\Entity\Orders;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShishaVerkoopType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('product1', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Product',
            'label' => 'Smaak 1',
            'label_attr' => ['class'=>'text-success'],
            'choice_value' => 'id',
            'choice_label' => 'smaak',
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('p')
                  ->where('p.shishapen = true');
            },
        ])
        ->add('product1Aantal', NumberType::class, [
            'mapped' => false,
            'label' => 'Smaak 1 aantal',
            'label_attr' => ['class'=>'text-success'],
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('product2', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Product',
            'label' => 'Smaak 2',
            'label_attr' => ['class'=>'text-success'],
            'required' => false,
            'choice_value' => 'id',
            'choice_label' => 'smaak',
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('p')
                  ->where('p.shishapen = true');
            },
        ])
        ->add('product2Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Smaak 2 aantal',
            'label_attr' => ['class'=>'text-success'],
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('product3', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Product',
            'label' => 'Smaak 3',
            'label_attr' => ['class'=>'text-success'],
            'choice_value' => 'id',
            'choice_label' => 'smaak',
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('p')
                  ->where('p.shishapen = true');
            },
        ])
        ->add('product3Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Smaak 3 aantal',
            'label_attr' => ['class'=>'text-success'],
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('product4', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Product',
            'label' => 'Smaak 4',
            'label_attr' => ['class'=>'text-success'],
            'required' => false,
            'choice_value' => 'id',
            'choice_label' => 'smaak',
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('p')
                  ->where('p.shishapen = true');
            },
        ])
        ->add('product4Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Smaak 4 aantal',
            'label_attr' => ['class'=>'text-success'],
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('product5', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Product',
            'label' => 'Smaak 5',
            'label_attr' => ['class'=>'text-success'],
            'choice_value' => 'id',
            'choice_label' => 'smaak',
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('p')
                  ->where('p.shishapen = true');
            },
        ])
        ->add('product5Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Smaak 5 aantal',
            'label_attr' => ['class'=>'text-success'],
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('product6', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Product',
            'label' => 'Smaak 6',
            'label_attr' => ['class'=>'text-success'],
            'choice_value' => 'id',
            'choice_label' => 'smaak',
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('p')
                  ->where('p.shishapen = true');
            },
        ])
        ->add('product6Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Smaak 6 aantal',
            'label_attr' => ['class'=>'text-success'],
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('betaalmethode', ChoiceType::class, array(
            'choices' => array(
                'Contant betalen' => 'Contant betalen',
                'ING Betaalverzoek' => 'ING Betaalverzoek',
                'Marktplaats betaalverzoek' => 'Marktplaats betaalverzoek',
                'Marktplaats gelijk oversteken service' => 'Marktplaats gelijk oversteken service',
            ),
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('koper', TextType::class, [
            'attr' => array('autocomplete' => 'off'),
        ])
        ->add('postcode', TextType::class, [
            'label' => 'Postcode (bijvoorbeeld: 2552HM)',
            'attr' => array('autocomplete' => 'off'),
            'required' => false,
        ])
        ->add('huisnummer', TextType::class, [
            'label' => 'Huisnummer (zonder toevoegsel)',
            'attr' => array('autocomplete' => 'off'),
            'required' => false,
        ])
        ->add('toevoegsel', TextType::class, [
            'label' => 'Huisnummer toevoegsel (bijvoorbeeld B)',
            'required' => false,
            'attr' => array('autocomplete' => 'off')
        ])
        ->add('verkoopprijs', MoneyType::class, array(
            'attr' => array('autocomplete' => 'off'),
        ))
        ->add('verkocht', ChoiceType::class, array(
            'choices' => array(
                'Ja' => true,
                'Nee' => false,
            ),
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('verzendkosten', MoneyType::class, array(
            'label' => 'Verzendkosten (niet verplicht)',
            'required' => false,
            'attr' => array('autocomplete' => 'off', 'class' => 'hide')
        ))
        ->add('extraInfo', TextareaType::class, array(
            'required' => false,
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('marktplaatsaccount', ChoiceType::class, [
            'choices' => [
                'Geen' => null,
                'Michel' => 'Michel',
                'Matthijs' => 'Matthijs',
                'Daniel' => 'Daniel',
                'Aested' => 'Aested',
            ],
            'label' => 'Marktplaats account'
        ])
        ->add('typeEnv', ChoiceType::class, [
            'mapped' => false,
            'label' => "Type enveloppe",
            'required' => true,
            'choices' => [
                'Geen enveloppe en postzegel' => 0,
                'Standaard deluxe enveloppe' => 3,
                'Bubbeltjes enveloppe klein' => 5,
                'Bubbeltjes enveloppe groot' => 8,
            ],
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Orders::class,
    ));
  }
}