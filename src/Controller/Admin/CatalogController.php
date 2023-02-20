<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[MenuItem('admin_catalog')]
final class CatalogController extends AbstractController
{
    #[MenuItem()]
    #[Route('/catalog', name: 'admin_catalog_list')]
    public function list()
    {
        throw $this->createNotFoundException();
    }
}
