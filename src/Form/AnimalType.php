<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Area;
use App\Entity\RecommandationVeterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('race')
            ->add('Area', EntityType::class, [
                'class' => Area::class,
                'choice_label' => 'name',
            ])
            ->add('recommandationVeterinary', EntityType::class, [
                'class' => RecommandationVeterinary::class,
                'choice_label' => 'id',
            ])
            ->add('images', FileType::class, [
                'label' => 'Images (JPEG, PNG, JPG)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\All([
                        new \Symfony\Component\Validator\Constraints\File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image (JPEG, JPG, or PNG)',
                        ]),
                    ]),
                ],
            ])
            ->add('existingImages', CollectionType::class, [
                'entry_type' => FileType::class,
                'mapped' => false,
                'required' => false,
                'allow_add' => false,
                'allow_delete' => true,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
