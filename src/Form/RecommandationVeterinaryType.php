<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\RecommandationVeterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Food;
use App\Form\FoodType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecommandationVeterinaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('foods', CollectionType::class, [
            'entry_type' => FoodType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ])
        ->add('medicine')
        ->add('date', null, [
            'widget' => 'single_text',
        ])
        ->add('state', ChoiceType::class, [
            'choices' => [
                'Bonne santé' => 'Bonne santé',
                'Malade' => 'Malade',
                'Blessé' => 'Bléssé',
                'En convalescence' => 'En convalescence',
            ],
        ])
        ->add('recommandation')
        ->add('report', null, [
            'required' => false,
        ])
        ->add('Animal', EntityType::class, [
            'class' => Animal::class,
            'choice_label' => 'id',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecommandationVeterinary::class,
        ]);
    }
}
