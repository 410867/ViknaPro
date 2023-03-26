<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Controller\AppAbstractController;
use App\Entity\Category;
use App\Object\Category\CategoryFilter;
use App\Object\Pagination\Pagination;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[MenuItem('admin_catalog')]
final class CatalogCategoryController extends AppAbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[MenuItem()]
    #[Route(self::ADMIN_PATH.'/catalog/category', name: 'admin_catalog_category')]
    public function index(CategoryFilter $filter): Response
    {
        $categories = $this->categoryRepository->findList($filter);
        $pagination = Pagination::newFromPaginator($categories, $filter->getLimitOffset());

        return $this->render('admin/catalog/category_index.html.twig', [
            'rows' => $categories,
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    #[Route(self::ADMIN_PATH.'/catalog/category/item', name: 'admin_catalog_category_item_new')]
    public function itemNew(Request $request): Response
    {
        return $this->createItemResponse(new Category(), $request);
    }

    #[Route(self::ADMIN_PATH.'/catalog/category/item/{id}', name: 'admin_catalog_category_item')]
    public function item(Category $category, Request $request): Response
    {
        return $this->createItemResponse($category, $request);
    }

    #[Route(self::ADMIN_PATH.'/catalog/category/item/{id}/delete', name: 'admin_catalog_category_item_delete')]
    public function itemDelete(Category $category, Request $request): Response
    {
        $this->categoryRepository->remove($category, true);
        return $this->redirectToRoute('admin_catalog_category');
    }

    private function createItemResponse(Category $category, Request $request): Response|RedirectResponse
    {
        if ($request->query->has('parent')){
            $category->setParent(
                $this->categoryRepository->find($request->query->getInt('parent'))
            );
        }

        $form = $this->createForm($category->getTemplate()->getFormType(), $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->save($category, true);

            $this->addFlash("success", 'Success save');

            return $this->redirectToRoute('admin_catalog_category_item', ['id' => $category->getId()]);
        }

        return $this->render('admin/catalog/category_item.html.twig', [
            'form' => $form,
            'item' => $category
        ]);
    }
}
