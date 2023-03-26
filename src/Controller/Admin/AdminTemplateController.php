<?php

namespace App\Controller\Admin;

use App\Attribute\MenuItem;
use App\Controller\AppAbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

#[MenuItem('debug')]
final class AdminTemplateController extends AppAbstractController
{
    public const ADMIN_TEMPLATE_URL = 'admin_template';
    private LoaderInterface $twigLoader;

    public function __construct(Environment $twig)
    {
        $this->twigLoader = $twig->getLoader();
    }

    #[MenuItem()]
    #[Route(self::ADMIN_PATH.'/template/{path}', name: self::ADMIN_TEMPLATE_URL)]
    public function root(string $path = 'index'): Response
    {
        $templateFile = "admin-template/$path.html.twig";

        if ($this->twigLoader->exists($templateFile)) {
            return $this->render($templateFile);
        }

        throw $this->createNotFoundException('The Requested Page Not Found.');
    }
}
