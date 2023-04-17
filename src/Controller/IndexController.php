<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AppAbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ServiceRepository $repository): Response
    {
        $services = $repository->findAll();

        return $this->render('front/index.html.twig', ['services' => $services]);
    }
}