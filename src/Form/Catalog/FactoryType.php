<?php

namespace App\Form\Catalog;

use App\Entity\Factory;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', CategoryChoiceType::class, [
                'required' => false
            ])
            ->add('title')
            ->add('slug')
            ->add('sort')
            ->add('img', ImageType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Factory::class,
        ]);
    }
}
