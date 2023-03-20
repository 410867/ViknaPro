<?php

namespace App\Form\Category;

use App\Entity\Category;
use App\Form\ImageType;
use App\Object\CategoryFilter\CategoryFilter;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CategoryType extends AbstractType
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (($category = $builder->getData()) instanceof Category) {
            $categoryId = $category->getId();
        } else {
            $categoryId = null;
        }

        $builder
            ->add('parent', ChoiceType::class, [
                'choice_label' => Category::TITLE_FIELD_NAME,
                'choices' => $this->repository->findList(CategoryFilter::findParentsWithoutCurrent($categoryId)),
                'required' => false,
            ])
            ->add('title')
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
