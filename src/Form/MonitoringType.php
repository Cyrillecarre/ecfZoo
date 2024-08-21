<?php

namespace App\Form;

use App\Entity\Monitoring;
use App\Entity\RecommandationVeterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Animal;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\FoodType;
use App\Entity\Food;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class MonitoringType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'disabled' => true,
            ])
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
            ->add('report')
            ->add('comment')
            ->add('recommandationVeterinary', EntityType::class, [
                'class' => RecommandationVeterinary::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Monitoring::class,
        ]);
    }
}
