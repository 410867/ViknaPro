<?php

namespace App\Controller\Admin;

use App\Controller\AppAbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AppAbstractController
{
    #[Route(self::ADMIN_PATH.'/', name: 'admin_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
