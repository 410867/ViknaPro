<?php

namespace App\Form\Service;

use App\Entity\Service;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('descriptionShort')
            ->add('sort')
            ->add('mainImg', ImageType::class, [
                'required' => false
            ])
            ->add('textImg', ImageType::class, [
                'required' => false
            ])
            ->add('workSteps', CollectionType::class, [
                'required' => false,
                'allow_delete' => false,
                'allow_add' => false,
                'entry_type' => TextareaType::class
            ])
            ->add('whyWe', CollectionType::class, [
                'required' => false,
                'allow_delete' => true,
                'allow_add' => true,
                'entry_type' => ServiceWhyWeType::class
            ])
            ->add('slug');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
