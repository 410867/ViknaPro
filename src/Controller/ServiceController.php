<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ServiceController extends AppAbstractController
{
    #[Route('/service', name: 'service', methods: ['GET'])]
    public function index(ServiceRepository $repository): Response
    {
        return $this->render('front/service/services.html.twig', [
            'rows' => $repository->findAll()
        ]);
    }

    #[Route('/service/{slug}', name: 'service_item', methods: ['GET'])]
    public function gallery(Service $service): Response
    {
        return $this->render('/front/service/service_item.html.twig', [
            'item' => $service
        ]);
    }
}
