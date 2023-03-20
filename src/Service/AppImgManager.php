<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

final class AppImgManager
{
    private string $projectDir;
    private Filesystem $filesystem;

    public function __construct(string $projectDir, Filesystem $filesystem)
    {
        $this->projectDir = $projectDir;
        $this->filesystem = $filesystem;
    }

    public function getPublicPathFromFullPath(string $fullPath): string
    {
        return '/' . $this->filesystem->makePathRelative(
                dirname($fullPath),
                $this->getPublicDir()
            ).basename($fullPath);
    }

    public function getPublicPathFromFilename(string $filename): string
    {
        return '/app-images/' . $filename;
    }

    public function getDir(): string
    {
        return $this->projectDir . '/public/app-images/';
    }

    public function getFullPathFromPublicPath(string $fileName): string
    {
        return $this->projectDir . '/public' . $fileName;
    }

    public function getPublicDir(): string
    {
        return $this->projectDir . '/public/';
    }

    public function getDefaultImage(): string
    {
        return '/images/no_img.jpg';
    }
}