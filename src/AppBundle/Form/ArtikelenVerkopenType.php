<?php

namespace AppBundle\Form;

use AppBundle\Entity\Klantenbestelling;
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

class ArtikelenVerkopenType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder
        ->add('artikel1', EntityType::class, [
            'mapped' => false,
            'class' => 'AppBundle\Entity\Artikel',
            'label' => 'Artikel 1',
            'choice_value' => 'id',
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('artikel1Aantal', NumberType::class, [
            'mapped' => false,
            'label' => 'Artikel 1 aantal',
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('artikel2', EntityType::class, [
            'mapped' => false,
            'class' => 'AppBundle\Entity\Artikel',
            'label' => 'Artikel 2',
            'required' => false,
            'choice_value' => 'id',
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('artikel2Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Artikel 2 aantal',
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('artikel3', EntityType::class, [
            'mapped' => false,
            'class' => 'AppBundle\Entity\Artikel',
            'label' => 'Artikel 3',
            'required' => false,
            'choice_value' => 'id',
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('artikel3Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Artikel 3 aantal',
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('artikel4', EntityType::class, [
            'mapped' => false,
            'class' => 'AppBundle\Entity\Artikel',
            'label' => 'Artikel 4',
            'required' => false,
            'choice_value' => 'id',
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('artikel4Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Artikel 4 aantal',
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('artikel5', EntityType::class, [
            'mapped' => false,
            'class' => 'AppBundle\Entity\Artikel',
            'label' => 'Artikel 5',
            'choice_value' => 'id',
            'required' => false,
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('artikel5Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Artikel 5 aantal',
            'attr' => ['autocomplete' => 'off'],
        ])
        ->add('artikel6', EntityType::class, [
            'mapped' => false,
            'class' => 'AppBundle\Entity\Artikel',
            'label' => 'Artikel 6',
            'choice_value' => 'id',
            'required' => false,
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('artikel6Aantal', NumberType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Artikel 6 aantal',
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
        'data_class' => Klantenbestelling::class,
        'shishaOption' => null,
    ));
  }
}