<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[MenuItem('admin_other')]
final class FeedbackController extends AbstractController
{
    #[MenuItem()]
    #[Route('/feedback', name: 'admin_feedback')]
    public function index(): Response
    {
        return $this->render('admin/other/feedback.html.twig');
    }
}