<?php

namespace App\Attribute;

use Attribute;

#[Attribute]
final class MenuItem
{
    const DEFAULT_PARENT_ROUTE = 'index';

    private ?string $route;
    private string $parentRoute;

    public function __construct(?string $route = null, string $parentRoute = self::DEFAULT_PARENT_ROUTE)
    {
        $this->route = $route;
        $this->parentRoute = $parentRoute;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function hasRoute(): bool
    {
        return !empty($this->route);
    }

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    public function setParentRoute(string $parentRoute): void
    {
        $this->parentRoute = $parentRoute;
    }

    public function getParentRoute(): string
    {
        return $this->parentRoute;
    }

    public function isDefaultParentRoute(): bool
    {
        return $this->parentRoute === self::DEFAULT_PARENT_ROUTE;
    }
}
