<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Controller\AppAbstractController;
use App\Entity\Service;
use App\Form\Service\ServiceType;
use App\Object\Filter;
use App\Object\Pagination\Pagination;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[MenuItem('admin_service_root')]
final class ServiceController extends AppAbstractController
{
    private ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    #[MenuItem()]
    #[Route(self::ADMIN_PATH.'/service', name: 'admin_service')]
    public function index(Filter $filter): Response
    {
        $rows = $this->serviceRepository->findList($filter);
        $pagination = Pagination::newFromPaginator($rows, $filter->getLimitOffset());

        return $this->render('admin/service/index.html.twig', [
            'rows' => $rows,
            'pagination' => $pagination,
            'filter' => $filter,
        ]);
    }

    #[Route(self::ADMIN_PATH.'/service/item', name: 'admin_service_item_new')]
    public function itemNew(Request $request): Response
    {
        return $this->createItemResponse(new Service(), $request);
    }

    #[Route(self::ADMIN_PATH.'/service/item/{id}', name: 'admin_service_item')]
    public function item(Service $service, Request $request): Response
    {
        return $this->createItemResponse($service, $request);
    }

    #[Route(self::ADMIN_PATH.'/service/item/{id}/delete', name: 'admin_service_item_delete')]
    public function itemDelete(Service $service): Response
    {
        $this->serviceRepository->remove($service, true);
        return $this->redirectToRoute('admin_service');
    }

    private function createItemResponse(Service $service, Request $request): Response|RedirectResponse
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->serviceRepository->save($service, true);

            $this->addFlash("success", 'Success save');

            return $this->redirectToRoute('admin_service_item', ['id' => $service->getId()]);
        }

        return $this->render('admin/service/item.html.twig', [
            'form' => $form,
            'item' => $service
        ]);
    }
}
