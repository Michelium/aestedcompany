<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BerekenVerkoopprijsType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('product', EntityType::class, array(
            'class' => 'App:Order',
            'choice_value' => 'product, naam',
            'choice_label' => 'naam',
        ))
        ->add('productnaam', TextType::class);
  }

}