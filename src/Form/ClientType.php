<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le nom ne doit pas être vide']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le nom doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 10,
                        'maxMessage' => 'Le numéro de téléphone doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('mobileNumber', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 10,
                        'maxMessage' => 'Le numéro de mobile doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('faxNumber', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 10,
                        'maxMessage' => 'Le numéro de fax doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
