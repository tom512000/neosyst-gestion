<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\SAV;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SAVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('representative', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le représentant doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('breakdown', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La panne doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('repairedBy', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le réparateur doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('repairs', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Les réparations doivent contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('comments', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Les observations doivent contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('charge', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La facturation doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SAV::class,
        ]);
    }
}
