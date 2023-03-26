<?php

namespace App\Form\Catalog;

use App\Entity\CategoryCollection;
use App\Entity\Product;
use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('img', ImageType::class, [
                'required' => false
            ])
            ->add('sort')
            ->add('category', CategoryChoiceType::class, [
                'required' => false
            ])
            ->add('collection', EntityType::class, [
                'required' => false,
                'class' => CategoryCollection::class,
                'choice_label' => 'title',
                'group_by' => fn(?CategoryCollection $collection) => $collection?->getFactory()->getTitle() . ' ('.($collection?->getFactory()?->getCategory()?->getTitle()).')'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
