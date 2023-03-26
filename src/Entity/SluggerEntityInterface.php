<?php

namespace App\Entity;

interface SluggerEntityInterface
{
    public function getTitle(): ?string;
    public function getSlug(): ?string;
    public function setSlug(?string $slug);
}