<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Entity\Product;
use App\Form\Catalog\ProductType;
use App\Object\Filter;
use App\Object\Pagination\Pagination;
use App\Repository\CategoryCollectionRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogProductController extends AbstractController
{
    private CategoryCollectionRepository $collectionRepository;
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;

    public function __construct(
        CategoryCollectionRepository $collectionRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    )
    {
        $this->collectionRepository = $collectionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    #[MenuItem(parentRoute: 'admin_catalog')]
    #[Route('/catalog/product', name: 'admin_catalog_product')]
    public function index(Filter $filter): Response
    {
        $rows = $this->productRepository->findList($filter);
        $pagination = Pagination::newFromPaginator($rows, $filter->getLimitOffset());

        return $this->render('admin/catalog/product_index.html.twig', [
            'rows' => $rows,
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    #[Route('/catalog/product/item', name: 'admin_catalog_product_item_new')]
    public function itemNew(Request $request): Response
    {
        return $this->createItemResponse(new Product(), $request);
    }

    #[Route('/catalog/product/item/{id}', name: 'admin_catalog_product_item')]
    public function item(Product $product, Request $request): Response
    {
        return $this->createItemResponse($product, $request);
    }

    #[Route('/catalog/product/item/{id}/delete', name: 'admin_catalog_product_item_delete')]
    public function itemDelete(Product $product): Response
    {
        $this->productRepository->remove($product, true);
        return $this->redirectToRoute('admin_catalog_product');
    }

    private function createItemResponse(Product $product, Request $request): Response|RedirectResponse
    {
        if ($request->query->has('category')){
            $product->setCategory(
                $this->categoryRepository->find($request->query->getInt('category'))
            );
        }

        if ($request->query->has('collection')){
            $product->setCollection(
                $this->collectionRepository->find($request->query->getInt('collection'))
            );
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productRepository->save($product, true);

            $this->addFlash("success", 'Success save');

            return $this->redirectToRoute('admin_catalog_product_item', ['id' => $product->getId()]);
        }

        return $this->render('admin/catalog/product_item.html.twig', [
            'form' => $form,
            'item' => $product
        ]);
    }
}
