<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse email.',
                    ]),
                    new Email([
                        'message' => 'L\'adresse email "{{ value }}" n\'est pas une adresse valide.',
                    ]),
                ],
            'required' => true,
        ])
        ->add('subject', TextType::class, [
            'label' => 'Sujet',
            'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un sujet.',
                    ]),
                ],
            'required' => true,
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message',
            'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un message.',
                    ]),
                ],
            'required' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
