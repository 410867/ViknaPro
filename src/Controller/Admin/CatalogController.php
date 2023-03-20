<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Entity\Category;
use App\Form\Category\CategoryType;
use App\Form\Category\ParentCategoryType;
use App\Object\CategoryFilter\CategoryFilter;
use App\Object\Pagination\Pagination;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[MenuItem('admin_catalog')]
final class CatalogController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[MenuItem()]
    #[Route('/catalog/category/{page<\d+>?1}', name: 'admin_catalog_category')]
    public function index(CategoryFilter $filter): Response
    {
        $categories = $this->categoryRepository->findList($filter);
        $pagination = Pagination::newFromPaginator($categories, $filter->getLimitOffset());

        return $this->render('admin/catalog/category_index.html.twig', [
            'categories' => $categories,
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    #[Route('/catalog/category/item', name: 'admin_catalog_category_item_new')]
    public function itemNew(Request $request): Response
    {
        return $this->createItemResponse(new Category(), $request);
    }

    #[Route('/catalog/category/item/{id}', name: 'admin_catalog_category_item')]
    public function item(Category $category, Request $request): Response
    {
        return $this->createItemResponse($category, $request);
    }

    #[Route('/catalog/category/item/{id}/new-child', name: 'admin_catalog_category_item_new_child')]
    public function itemNewChild(Category $parent, Request $request): Response
    {
        return $this->createItemResponse(
            (new Category())->setParent($parent),
            $request
        );
    }

    #[Route('/catalog/category/item/{id}/delete', name: 'admin_catalog_category_item_delete')]
    public function itemDelete(Category $category, Request $request): Response
    {
        $this->categoryRepository->remove($category, true);

        return $this->redirectToRoute('admin_catalog_category');
    }

    private function createItemResponse(Category $category, Request $request): Response|RedirectResponse
    {
        if (null === $category->getParent()){
            $formType = ParentCategoryType::class;
            $parent = $category;
        } else {
            $formType = CategoryType::class;
            $parent = $category->getParent();
        }

        $form = $this->createForm($formType, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->save($category, true);

            $this->addFlash("success", 'Success save');

            return $this->redirectToRoute('admin_catalog_category_item', ['id' => $category->getId()]);
        }

        return $this->render('admin/catalog/category_item.html.twig', [
            'form' => $form,
            'contextCategories' => $category->getId() ? [$parent, ...$parent->getChildren()->toArray()] : [],
            'currentCategory' => $category,
            'parent' => $parent
        ]);
    }
}
