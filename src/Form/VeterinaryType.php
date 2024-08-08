<?php

namespace App\Form;

use App\Entity\Veterinary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class VeterinaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', TextType::class, [
            'label' => 'Email',
            'required' => true,
            'attr' => ['class' => 'form-control']
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Mot de Passe',
            'required' => true,
            'attr' => ['class' => 'form-control'],
            'help' => 'Laissez vide pour conserver le mot de passe actuel.'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veterinary::class,
        ]);
    }
}
