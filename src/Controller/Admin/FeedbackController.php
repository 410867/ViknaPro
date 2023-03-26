<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Controller\AppAbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[MenuItem('admin_other')]
final class FeedbackController extends AppAbstractController
{
    #[MenuItem()]
    #[Route(self::ADMIN_PATH.'/feedback', name: 'admin_feedback')]
    public function index(): Response
    {
        return $this->render('admin/other/feedback.html.twig');
    }
}