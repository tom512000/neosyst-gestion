<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'La description ne doit pas être vide']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le code doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'step' => 0.05,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le prix ne doit pas être vide']),
                    new PositiveOrZero(['message' => 'Le prix doit être positif ou nul']),
                ],
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image (fichier JPG ou PNG)',
                'required' => false,
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
