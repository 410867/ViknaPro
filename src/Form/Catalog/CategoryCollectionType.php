<?php

namespace App\Form\Catalog;

use App\Entity\CategoryCollection;
use App\Entity\Factory;
use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('factory', EntityType::class, [
                'required' => false,
                'class' => Factory::class,
                'choice_label' => 'title',
                'group_by' => fn(?Factory $factory) => $factory?->getCategory()->getTitle() . ' ('.($factory?->getCategory()?->getParent()?->getTitle()).')'
            ])
            ->add('title')
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('slug', TextType::class, [
                'required' => false
            ])
            ->add('sort')
            ->add('img', ImageType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryCollection::class,
        ]);
    }
}
