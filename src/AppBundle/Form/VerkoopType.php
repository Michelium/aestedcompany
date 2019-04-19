<?php

namespace AppBundle\Form;
use AppBundle\Entity\Orders;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VerkoopType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('betaalmethode', ChoiceType::class, array(
            'choices' => array(
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
            'attr' => array('autocomplete' => 'off')
        ])
        ->add('huisnummer', TextType::class, [
            'label' => 'Huisnummer (zonder toevoegsel)',
            'attr' => array('autocomplete' => 'off')
        ])
        ->add('toevoegsel', TextType::class, [
            'label' => 'Huisnummer toevoegsel (bijvoorbeeld B)',
            'required' => false,
            'attr' => array('autocomplete' => 'off')
        ])
        ->add('verkoopprijs', MoneyType::class, array(
            'attr' => array('autocomplete' => 'off'),
        ))
        ->add('aantalproducten', NumberType::class, [
            'label' => 'Aantal',
            'attr' => array('autocomplete' => 'off'),
            'required' => false,
        ])
        ->add('verkocht', ChoiceType::class, array(
            'required' => false,
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
        ->add('extraInfo', TextareaType::class, array(
            'required' => false,
            'attr' => array('autocomplete' => 'off')
        ));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'data_class' => Orders::class,
    ));
  }
}