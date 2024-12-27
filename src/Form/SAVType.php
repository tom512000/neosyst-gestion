<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\SAV;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SAVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('createdDate', null, [
                'widget' => 'single_text',
            ])
            ->add('representative')
            ->add('breakdown')
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('repairedBy')
            ->add('repairs')
            ->add('comments')
            ->add('charge')
            ->add('spreadsheetName')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
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
