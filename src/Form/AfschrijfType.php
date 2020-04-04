<?php

namespace App\Form;

use App\Entity\Afschrijving;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AfschrijfType extends AbstractType {
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
        ->add('aantal', NumberType::class, [
            'constraints' => [
                new NotBlank(),
            ]
        ])
        ->add('reden', ChoiceType::class, array(
            'choices' => [
                'Breuk' => 'Breuk',
                'Cadeau' => 'Cadeau',
                'Eigen gebruik' => 'Eigen gebruik',
            ]
        ))
        ->add('redenText', TextareaType::class, array(
            'label' => 'Extra reden (niet verplicht)',
            'attr' => array('autocomplete' => 'off'),
            'required' => false,
        ));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Afschrijving::class,
        'shishaOption' => null,
    ));
  }
}