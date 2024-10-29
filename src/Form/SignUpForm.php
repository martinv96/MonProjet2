<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SignUpForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'email est obligatoire.']),
                    new Assert\Email(['message' => 'Email invalide.']),
                ],
                'attr' => ['placeholder' => 'Entrez votre email']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot de passe est obligatoire.']),
                    new Assert\Length(['min' => 6, 'minMessage' => 'Le mot de passe doit contenir au moins 6 caractères.']),
                ],
                'attr' => ['placeholder' => 'Entrez votre mot de passe']
            ])
            // ->add('confirm_password', PasswordType::class, [
            //     'label' => 'Confirmez le mot de passe',
            //     'constraints' => [
            //         new Assert\NotBlank(['message' => 'La confirmation du mot de passe est obligatoire.']),
            //     ],
            //     'attr' => ['placeholder' => 'Confirmez votre mot de passe']
            // ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'bouton'],
                'label' => 'S\'inscrire'
            ]);
    }
}
