<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre email',
                    'class' => 'form-control',

                ],
                'label' => 'Email'
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre nom',
                    'class' => 'form-control',

                ],
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre prénom',
                    'class' => 'form-control',

                ],
                'label' => 'Prénom'
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre adresse',
                    'class' => 'form-control',

                ],
                'label' => 'Adresse'
            ])
            ->add('postalcode', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre code postal',
                    'class' => 'form-control',

                ],
                'label' => 'Code postal'
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre ville',
                    'class' => 'form-control',

                ],
                'label' => 'Ville'
           ])
           ->add('country' , TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre pays',
                    'class' => 'form-control',

                ],
                'label' => 'Pays'
            ])

            ->add('phone', TelType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre numéro de téléphone',
                    'class' => 'form-control',

                ],
                'label' => 'Téléphone'
            ])

            ->add('agreeTerms', CheckboxType::class, [
                                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),

                ],
                'label' => 'J\'accepte les conditions d\'utilisation du site',
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),

                ],
                'label' => 'En m\'inscrivant, j\'accepte que mes données soient utilisées pour me contacter dans le cadre de ma demande d\'inscription.',
                ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre mot de passe',
                    'autocomplete' => 'new-password',
                    'class' => 'form-control',],
                    'label' => 'Mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe',
                'help' => 'Votre mot de passe doit contenir au moins 6 caractères',

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
