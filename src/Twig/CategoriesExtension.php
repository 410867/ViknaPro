<?php

namespace App\Twig;

use App\Object\Category\CategoryFilter;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Generator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class CategoriesExtension extends AbstractExtension
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getFunctions(): array|Generator
    {
        yield new TwigFunction('parent_categories', fn() => $this->getParentCategories());
    }

    private function getParentCategories(): Paginator
    {
        return $this->categoryRepository->findList(CategoryFilter::new()->root());
    }
}