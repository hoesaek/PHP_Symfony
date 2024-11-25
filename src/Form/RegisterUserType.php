<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email :",
                'attr' => [
                    'placeholder' => "votre adresse email"
                ]
                ])
            ->add('lastname',TextType::class, [
                    'label' => "Nom :",
                    'constraints' => [
                            new Length([
                                'min' => 2,
                                'max' => 30,
                                'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                                'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.'
                            ])
                    ],
                    'attr' => [
                        'placeholder' => "votre votre nom"
                    ]
                ])
            ->add('firstname',TextType::class, [
                    'label' => "Prénom : ",
                    'constraints' => [
                            new Length([
                                'min' => 2,
                                'max' => 30,
                                'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                                'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.'
                            ])
                    ],
                    'attr' => [
                        'placeholder' => "votre prénom"
                    ]
                ])
            // ->add('password', PasswordType::class, [
            //         'label' => "Votre mot de passe :",
            //         'attr' => [
            //             'placeholder' => "votre mot de passe"
            //         ]
            // ])
            ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => [
                        'label' => 'Choisissez votre mot de passe', 'hash_property_path' => 'password',
                        'constraints' => [
                            new Length([
                                'min' => 3,
                                'max' => 30,
                                'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                                'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.'
                            ])
                        ],
                        'attr' => [
                            'placeholder' => "votre mot de passe"
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Confirmer votre mot de passe',
                        'attr' => [
                            'placeholder' => "confirmer votre mot de passe"
                        ]
                    ],
                    'mapped' => false, // n essaie pas de faire le lien entre l entité 'user' et le champ que je te donne , mon champ password dans l entité user s appel password et non plainPassword
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    'class' => "btn btn-outline-success"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                        'entityClass' => User::class,
                        'fields' => 'email'
                    ]
                )
            ],
            'data_class' => User::class,
        ]);
    }
}
