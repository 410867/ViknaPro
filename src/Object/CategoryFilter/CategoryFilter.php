<?php

namespace App\Object;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Valid;

final class CategoryFilter implements FromRequestObjectInterface
{
    #[Valid]
    private LimitOffset $limitOffset;
    private null|string $search = null;
    private bool $root = false;

    public static function newFromRequest(Request $request): static
    {
        $res = new self();
        $res->limitOffset = LimitOffset::newFromRequest($request);
        $res->search = $request->query->get('search');

        return $res;
    }

    public function getLimitOffset(): LimitOffset
    {
        return $this->limitOffset;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->root;
    }

    public function setRoot(): CategoryFilter
    {
        $this->root = true;
        return $this;
    }
}
