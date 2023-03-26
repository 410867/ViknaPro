<?php

namespace App\Form\Catalog;

use App\Entity\Category;
use App\Form\ImageType;
use App\Object\Category\CategoryTemplateEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (($category = $builder->getData()) instanceof Category) {
            $categoryId = $category->getId();
        } else {
            $categoryId = null;
        }

        $builder
            ->add('template', EnumType::class, ['class' => CategoryTemplateEnum::class])
            ->add('parent', CategoryChoiceType::class, [
                'required' => false,
                'current_category_id' => $categoryId
            ])
            ->add('title')
            ->add('slug')
            ->add('description', TextareaType::class, [
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
            'data_class' => Category::class,
        ]);
    }
}
