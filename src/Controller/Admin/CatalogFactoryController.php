<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Controller\AppAbstractController;
use App\Entity\Factory;
use App\Form\Catalog\FactoryType;
use App\Object\Filter;
use App\Object\Pagination\Pagination;
use App\Repository\CategoryRepository;
use App\Repository\FactoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogFactoryController extends AppAbstractController
{
    private CategoryRepository $categoryRepository;
    private FactoryRepository $factoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        FactoryRepository $factoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->factoryRepository = $factoryRepository;
    }

    #[MenuItem(parentRoute: 'admin_catalog')]
    #[Route(self::ADMIN_PATH.'/catalog/factory', name: 'admin_catalog_factory')]
    public function index(Filter $filter): Response
    {
        $rows = $this->factoryRepository->findList($filter);
        $pagination = Pagination::newFromPaginator($rows, $filter->getLimitOffset());

        return $this->render('admin/catalog/factory_index.html.twig', [
            'rows' => $rows,
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    #[Route(self::ADMIN_PATH.'/catalog/factory/item', name: 'admin_catalog_factory_item_new')]
    public function itemNew(Request $request): Response
    {
        return $this->createItemResponse(new Factory(), $request);
    }

    #[Route(self::ADMIN_PATH.'/catalog/factory/item/{id}', name: 'admin_catalog_factory_item')]
    public function item(Factory $item, Request $request): Response
    {
        return $this->createItemResponse($item, $request);
    }

    #[Route(self::ADMIN_PATH.'/catalog/factory/item/{id}/delete', name: 'admin_catalog_factory_item_delete')]
    public function itemDelete(Factory $factory): Response
    {
        $this->factoryRepository->remove($factory, true);
        return $this->redirectToRoute('admin_catalog_factory');
    }

    private function createItemResponse(Factory $item, Request $request): Response|RedirectResponse
    {
        if ($request->query->has('category')){
            $item->setCategory(
                $this->categoryRepository->find($request->query->getInt('category'))
            );
        }

        $form = $this->createForm(FactoryType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->factoryRepository->save($item, true);

            $this->addFlash("success", 'Success save');

            return $this->redirectToRoute('admin_catalog_factory_item', ['id' => $item->getId()]);
        }

        return $this->render('admin/catalog/factory_item.html.twig', [
            'form' => $form,
            'item' => $item
        ]);
    }
}