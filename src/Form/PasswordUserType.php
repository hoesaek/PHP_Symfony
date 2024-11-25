<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => "Mot de passe :",
                'attr' => [
                    'placeholder' => "Votre mot de passe actuel ..."
                ],
                'mapped' => false,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Choisissez votre mots de passe', 'hash_property_path' => 'password',
                    'constraints' => [
                        new Length([
                            'min' => 3,
                            'max' => 30,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.'
                        ])
                    ],
                    'attr' => [
                        'placeholder' => "votre nouveau mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'attr' => [
                        'placeholder' => "confirmer votre nouveau mot de passe"
                    ]
                ],
                'mapped' => false, // n essaie pas de faire le lien entre l entité 'user' et le champ que je te donne , mon champ password dans l entité user s appel password et non plainPassword
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre a jour mon mot de passe",
                'attr' => [
                    'class' => "btn btn-outline-success"
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];

                //recuperer le mdp saisie par l utilisateur et le comparer au mdp en bdd (dans l entité)
                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $form->get('actualPassword')->getData()
                );
                if(!$isValid){
                    $form->get('actualPassword')->addError(new FormError('Le mot de passe saisie n\'est passe conforme'));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null,
        ]);
    }
}
