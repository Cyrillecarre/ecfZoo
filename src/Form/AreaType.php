<?php

namespace App\Form;

use App\Entity\Area;
use App\Entity\PictureArea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('comment', TextType::class, ['required' => false])
            ->add('images', FileType::class, [
                'label' => 'Images (JPEG, PNG, JPG)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\All([
                        new \Symfony\Component\Validator\Constraints\File([
                            'maxSize' => '5M',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Area::class,
        ]);
    }
}
