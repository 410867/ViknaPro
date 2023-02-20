<?php

namespace App\Twig;

use App\Controller\Admin\AdminTemplateController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AdminTemplatePathExtension extends AbstractExtension
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('admin_template_path', [$this, 'doFilter'])
        ];
    }

    public function doFilter(string $path): string
    {
        return $this->urlGenerator->generate(AdminTemplateController::ADMIN_TEMPLATE_URL, [
            'path' => $path
        ]);
    }
}