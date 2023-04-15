<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ContactController extends AppAbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function index(ServiceRepository $repository): Response
    {
        return $this->render('front/contact/contacts.html.twig', [
            'rows' => $repository->findAll()
        ]);
    }
}
