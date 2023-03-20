<?php

namespace App\Form\Category;

use App\Entity\Category;
use App\Object\CategoryFilter\CategoryFilter;
use App\Repository\CategoryRepository;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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

    /**
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->categoryType->buildForm($builder, $options);

        $builder->add('children', EntityType::class, [
            'choice_label' => Category::TITLE_FIELD_NAME,
            'choices' => $this->repository->findList(CategoryFilter::allChildren())->getIterator()->getArrayCopy(),
            'class' => Category::class,
            'multiple' => true,
            'by_reference' => false,
            'group_by' => fn(null|Category $category) => $category?->getParent()?->getTitle(),
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $this->categoryType->configureOptions($resolver);
    }
}