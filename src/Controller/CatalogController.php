<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategoryCollection;
use App\Object\Category\CategoryTemplateEnum;
use App\Object\ProductFilter;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogController extends AppAbstractController
{
    #[Route('/catalog/category/{slug}', name: 'category', methods: ['GET'])]
    public function index(Category $category, ProductRepository $repository, ProductFilter $filter): Response
    {
        $data = [
            'category' => $category
        ];

        if ($category->getTemplate() === CategoryTemplateEnum::PRODUCTS){
            $filter->setCategoryId($category->getId());
            $data['products'] = $repository->findList($filter);
            $data['filter'] = $filter;
            $template = 'front/catalog/products.html.twig';
        } else {
            $template = 'front/catalog/' . strtolower($category->getTemplate()->value) . '.html.twig';
        }

        return $this->render($template, $data);
    }

    #[Route('/catalog/category/gallery/{context<videos|images>}/{slug}', name: 'category_gallery', methods: ['GET'])]
    public function gallery(string $context, Category $category): Response
    {
        return $this->render('/front/catalog/gallery_full.html.twig', [
            'category' => $category,
            'context' => $context
        ]);
    }

    #[Route('/catalog/our-works', name: 'our_works', methods: ['GET'])]
    public function ourWorks(): Response
    {
        return $this->render('/front/catalog/our_works.html.twig');
    }

    #[Route('/catalog/collection/products/{slug}', name: 'collection_products', methods: ['GET'])]
    public function collection(CategoryCollection $collection, ProductRepository $repository, ProductFilter $filter): Response
    {
        $filter->setCollectionId($collection->getId());

        return $this->render('/front/catalog/collection_products.html.twig', [
            'collection' => $collection,
            'products' => $repository->findList($filter),
            'filter' => $filter
        ]);
    }
}
