<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\RecommandationVeterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecommandationVeterinaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('food')
            ->add('quantity')
            ->add('medicine')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('state')
            ->add('recommandation')
            ->add('report')
            ->add('Animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecommandationVeterinary::class,
        ]);
    }
}
