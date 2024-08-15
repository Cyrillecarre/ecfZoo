<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('count', ChoiceType::class, [
                'choices' => [
                    '1 étoile' => 1,
                    '2 étoile' => 2,
                    '3 étoile' => 3,
                    '4 étoile' => 4,
                    '5 étoile' => 5,
                ],
                'constraints' => [
                    new Choice([
                        'choices' => [1, 2, 3, 4, 5],
                        'message' => 'Choose a value between 1 and 5',
                    ]),
                ],
            ])
            ->add('content')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
