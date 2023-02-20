<?php

namespace App\Object;

final class MenuItem
{
    private string $route;

    /**
     * @var array<MenuItem>
     */
    private array $children;

    public function __construct(string $route, array $children)
    {
        $this->route = $route;
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
