<?php

namespace App\Twig;

use App\Service\AppImgManager;
use Symfony\Component\HttpFoundation\File\File;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AppImgExtension extends AbstractExtension
{
    private AppImgManager $appImgManager;

    public function __construct(AppImgManager $appImgManager)
    {
        $this->appImgManager = $appImgManager;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('app_img', [$this, 'img'])
        ];
    }

    public function img(null|string|File $file): string
    {
        if (null === $file){
            return $this->appImgManager->getDefaultImage();
        }

        if ($file instanceof File){
            return $this->appImgManager->getPublicPathFromFullPath($file->getPathname());
        }

        return $file;
    }
}
