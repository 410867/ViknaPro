<?php

namespace App\Form\Catalog;

use App\Entity\Category;
use App\Object\Category\CategoryFilter;
use App\Repository\CategoryRepository;
use Exception;
use Symfony\Component\Form\ChoiceList\Factory\ChoiceListFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CategoryChoiceType extends ChoiceType
{
    private CategoryRepository $repository;

    public function __construct(
        CategoryRepository         $repository,
        ChoiceListFactoryInterface $choiceListFactory = null,
        TranslatorInterface        $translator = null
    )
    {
        parent::__construct($choiceListFactory, $translator);
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentCategoryId = $options['current_category_id'];
        $options['choices'] = $this->repository->findList(
            CategoryFilter::newFormChoices($currentCategoryId)
        )->getIterator()->getArrayCopy();
        $options['choice_label'] = fn(null|Category $category) => self::getLabel($category);

        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['choice_label'] = fn (null|Category $category) => self::getLabel($category);
        parent::buildView($view, $form, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'current_category_id' => null
        ]);
    }

    private static function nestingLevel(?Category $category): int
    {
        return count(explode('_', $category->getNesting())) - 1;
    }

    private static function getLabel(?Category $category): ?string
    {
        $level = self::nestingLevel($category);

        if (0 === $level) {
            return $category->getTitle();
        }

        return str_repeat(" * ", self::nestingLevel($category)) . $category->getTitle();
    }
}
