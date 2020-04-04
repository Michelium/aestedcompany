<?php

namespace App\Form;

use App\Entity\Bestelling;
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

class BestellingType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('artikel', EntityType::class, [
            'mapped' => false,
            'class' => 'App\Entity\Artikel',
            'label' => 'Artikel',
            'choice_value' => 'id',
            'choice_label' => function ($artikel) {
              return $artikel->getCategorie() . ' >>> ' . $artikel->getNaam();
            },
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->createQueryBuilder('p')
                  ->where("p.shishapen = " . json_encode($options['shishaOption']) );
            },
        ])
        ->add('productextra', TextType::class, array(
            'label' => 'Product niet in de lijst (niet verplicht)',
            'mapped' => false,
            'required' => false,
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('aantal', NumberType::class, array(
            'label' => 'Aantal',
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('bedrag', MoneyType::class, array(
            'attr' => array('autocomplete' => 'off')
        ))
        ->add('korting', PercentType::class, array(
            'attr' => array('autocomplete' => 'off'),
            'type' => 'integer',
            'required' => false,
        ))
        ->add('extraInfo', TextareaType::class, [
            'attr' => ['autocomplete' => 'off'],
            'required' => false,
            'label' => 'Extra informatie (niet verplicht)'
        ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Bestelling::class,
        'shishaOption' => null,
    ));
  }
}