<?php

namespace App\Form;

use App\Entity\Food;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, [
                'choices' => [
                    'Viande' => 'viande',
                    'Légume' => 'legume',
                    'Fruit' => 'fruit',
                    'poisson' => 'poisson',
                    'graine' => 'graine',
                    'insecte' => 'insecte',
                    'foin' => 'foin',
                ],
                'label' => 'Type d\'aliment',
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité en grammes',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
