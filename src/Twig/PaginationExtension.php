<?php

namespace App\Twig;

use App\Object\LimitOffset;
use App\Object\Pagination\Page;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class PaginationExtension extends AbstractExtension
{
    private RequestStack $requestStack;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $urlGenerator)
    {
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('app_page_url', [$this, 'pageUrl'])
        ];
    }

    public function pageUrl(int|Page $page): string
    {
        if ($page instanceof Page){
            $page = $page->getPage();
        }

        $req = $this->requestStack->getCurrentRequest();
        $route = $req->get('_route');
        $params = $req->attributes->get('_route_params') + $req->query->all();
        $params[LimitOffset::PAGE_PARAM] = $page;

        return $this->urlGenerator->generate($route, $params);
    }
}
