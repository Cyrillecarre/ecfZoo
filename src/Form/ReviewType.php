<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', textType::class, [
                'label' => 'Nom',
                ])
            ->add('count', HiddenType::class, [
                'attr' => ['class' => 'star-rating-input',
                'data-js-target' => 'starRating'
            ],
            ])
            ->add('content', textAreaType::class, [
                'label' => 'Commentaire',
                'attr' => ['rows' => 5],
            ])
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
