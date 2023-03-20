<?php

namespace App\Form;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ParentCategoryType extends AbstractType
{
    private CategoryRepository $repository;
    private CategoryType $categoryType;

    public function __construct(CategoryRepository $repository, CategoryType $categoryType)
    {
        $this->repository = $repository;
        $this->categoryType = $categoryType;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->categoryType->buildForm($builder, $options);
        $builder->add('children', ChoiceType::class, [
            'choice_label' => Category::TITLE_FIELD_NAME,
            'choices' => $this->repository->findChildren()
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $this->categoryType->configureOptions($resolver);
    }
}