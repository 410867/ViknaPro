<?php

namespace App\Object;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Valid;

final class ProductFilter implements FromRequestObjectInterface
{
    #[Valid]
    private ?LimitOffset $limitOffset = null;
    private null|string $search = null;
    private null|int $collectionId = null;

    public static function new(): ProductFilter
    {
        return new self();
    }

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

    public function hasLimitOffset(): bool
    {
        return null !== $this->limitOffset;
    }

    public function getCollectionId(): ?int
    {
        return $this->collectionId;
    }

    public function setCollectionId(?int $collectionId): self
    {
        $this->collectionId = $collectionId;
        return $this;
    }
}
