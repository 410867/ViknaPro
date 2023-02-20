<?php

namespace App\Twig;

use App\Attribute\MenuItem as MenuItemAttr;
use App\Object\MenuItem;
use ReflectionException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    private RouterInterface $router;
    private string $projectDir;

    /**
     * @var MenuItemAttr[][]
     */
    private ?array $attributesIndexParent = null;

    /**
     * @var array<Route>
     */
    private ?array $routeControllerIndex = null;

    public function __construct(RouterInterface $router, string $projectDir)
    {
        $this->router = $router;
        $this->projectDir = $projectDir;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('menu', [$this, 'getMenu'])
        ];
    }

    /**
     * @return array<MenuItem>
     * @throws ReflectionException
     */
    public function getMenu(string $parentRoute = MenuItemAttr::DEFAULT_PARENT_ROUTE): array
    {
        $attributes = $this->getAttributesIndexParent()[$parentRoute] ?? [];

        if (empty($attributes)) {
            return [];
        }

        $result = [];
        foreach ($attributes as $attribute) {
            $result[] = new MenuItem(
                $attribute->getRoute(),
                $this->getMenu($attribute->getRoute())
            );
        }

        return $result;
    }

    /**
     * @return array<MenuItemAttr>
     * @throws ReflectionException
     */
    private function getDirAttributes(string $scanDir): array
    {
        $result = [];
        foreach (scandir($scanDir) as $name) {
            if (in_array($name, ['.', '..'])) {
                continue;
            }

            $path = $scanDir . '/' . $name;
            if (is_dir($path)) {
                $result = array_merge($result, $this->getDirAttributes($path));
            } else {
                $result = array_merge($result, $this->getControllerAttributes($path));
            }
        }

        return $result;
    }

    /**
     * @return array<MenuItemAttr>
     * @throws ReflectionException
     */
    private function getControllerAttributes(string $path): array
    {
        $reflectionClass = new \ReflectionClass($this->getClassFromPath($path));

        $result = [];

        $parentRouteAttr = $this->getDefaultParentRoute($reflectionClass);
        if ($parentRouteAttr) {
            $result[] = $parentRouteAttr;
        }

        foreach ($reflectionClass->getMethods() as $method) {
            foreach ($method->getAttributes(MenuItemAttr::class) as $attribute) {
                $result[] = $this->getMenuItem($attribute, $method, $parentRouteAttr);
            }
        }

        return $result;
    }

    /**
     * @return MenuItemAttr[][]
     * @throws ReflectionException
     */
    private function getAttributesIndexParent(): array
    {
        if (null === $this->attributesIndexParent) {
            $attributes = $this->getDirAttributes(
                $this->getSrcPath('Controller/Admin')
            );

            foreach ($attributes as $attribute) {
                $this->attributesIndexParent[$attribute->getParentRoute()][] = $attribute;
            }
        }

        return $this->attributesIndexParent;
    }

    private function getClassFromPath(string $path): string
    {
        $replace = [
            $this->getSrcPath('') => '',
            '/' => '\\',
            '.php' => ''
        ];

        return $this->getSrcNamespace() . '\\' . str_replace(array_keys($replace), array_values($replace), $path);
    }

    private function getSrcPath(string $path): string
    {
        return $this->projectDir . '/src/' . $path;
    }

    private function getSrcNamespace(): string
    {
        return 'App';
    }

    private function getDefaultParentRoute(\ReflectionClass $reflectionClass): ?MenuItemAttr
    {
        foreach ($reflectionClass->getAttributes(MenuItemAttr::class) as $attribute) {
            return $attribute->newInstance();
        }

        return null;
    }

    private function getMenuItem(\ReflectionAttribute $attribute, \ReflectionMethod $method, ?MenuItemAttr $parentRoute): MenuItemAttr
    {
        /**
         * @var $attrInst MenuItemAttr
         */
        $attrInst = $attribute->newInstance();

        if (!$attrInst->hasRoute()) {
            $attrInst->setRoute($this->getRoute($method));
        }
        if ($attrInst->isDefaultParentRoute()) {
            $attrInst->setParentRoute(
                $parentRoute ? $parentRoute->getRoute() : MenuItemAttr::DEFAULT_PARENT_ROUTE
            );
        }

        return $attrInst;
    }

    private function getRoute(\ReflectionMethod $method): string
    {
        return $this->getRouteForControllerIndex(
            $method->getDeclaringClass()->getName() . '::' . $method->getName()
        );
    }

    private function getRouteForControllerIndex(string $controller): string
    {
        if (null === $this->routeControllerIndex) {
            /**
             * @var $route Route
             */
            foreach ($this->router->getRouteCollection() as $routeName => $route) {
                $this->routeControllerIndex[$route->getDefault('_controller')] = $routeName;
            }
        }

        return $this->routeControllerIndex[$controller];
    }
}
