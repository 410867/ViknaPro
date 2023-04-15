<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Controller\AppAbstractController;
use App\Entity\CategoryCollection;
use App\Form\Catalog\CategoryCollectionType;
use App\Object\Filter;
use App\Object\Pagination\Pagination;
use App\Repository\CategoryCollectionRepository;
use App\Repository\FactoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogCollectionController extends AppAbstractController
{
    private CategoryCollectionRepository $collectionRepository;
    private FactoryRepository $factoryRepository;

    public function __construct(
        CategoryCollectionRepository $collectionRepository,
        FactoryRepository $factoryRepository
    )
    {
        $this->collectionRepository = $collectionRepository;
        $this->factoryRepository = $factoryRepository;
    }

    #[Route(self::ADMIN_PATH.'/catalog/collection', name: 'admin_catalog_collection')]
    public function index(Filter $filter): Response
    {
        $collection = $this->collectionRepository->findList($filter);
        $pagination = Pagination::newFromPaginator($collection, $filter->getLimitOffset());

        return $this->render('admin/catalog/collection_index.html.twig', [
            'rows' => $collection,
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    #[Route(self::ADMIN_PATH.'/catalog/collection/item', name: 'admin_catalog_collection_item_new')]
    public function itemNew(Request $request): Response
    {
        return $this->createItemResponse(new CategoryCollection(), $request);
    }

    #[Route(self::ADMIN_PATH.'/catalog/collection/item/{id}', name: 'admin_catalog_collection_item')]
    public function item(CategoryCollection $collection, Request $request): Response
    {
        return $this->createItemResponse($collection, $request);
    }

    #[Route(self::ADMIN_PATH.'/catalog/collection/item/{id}/delete', name: 'admin_catalog_collection_item_delete')]
    public function itemDelete(CategoryCollection $collection): Response
    {
        $this->collectionRepository->remove($collection, true);
        return $this->redirectToRoute('admin_catalog_collection');
    }

    private function createItemResponse(CategoryCollection $collection, Request $request): Response|RedirectResponse
    {
        if ($request->query->has('factory')){
            $collection->setFactory(
                $this->factoryRepository->find($request->query->getInt('factory'))
            );
        }

        $form = $this->createForm(CategoryCollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->collectionRepository->save($collection, true);

            $this->addFlash("success", 'Success save');

            return $this->redirectToRoute('admin_catalog_collection_item', ['id' => $collection->getId()]);
        }

        return $this->render('admin/catalog/collection_item.html.twig', [
            'form' => $form,
            'item' => $collection
        ]);
    }
}
