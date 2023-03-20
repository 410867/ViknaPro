<?php

namespace App\Object\CategoryFilter;

use App\Object\FromRequestObjectInterface;
use App\Object\LimitOffset;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Valid;

final class CategoryFilter implements FromRequestObjectInterface
{
    #[Valid]
    private ?LimitOffset $limitOffset = null;
    private null|string $search = null;
    private bool $root = false;
    private bool $children = false;
    private array $excludeIds = [];

    public static function new(): CategoryFilter
    {
        return new self();
    }

    public static function newFromRequest(Request $request): static
    {
        $res = new self();
        $res->limitOffset = LimitOffset::newFromRequest($request);
        $res->search = $request->query->get('search');
        $res->root = $request->query->getInt('is_root', 1) === 1;

        return $res;
    }

    public static function allChildren(): CategoryFilter
    {
        return self::new()->children();
    }

    public static function findParentsWithoutCurrent(?int $currentId): CategoryFilter
    {
        $res = self::new()->root();
        if ($currentId){
            $res->addExcludeId($currentId);
        }

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

    public function isRoot(): bool
    {
        return $this->root;
    }

    public function root(): CategoryFilter
    {
        $this->root = true;
        return $this;
    }

    public function isChildren(): bool
    {
        return $this->children;
    }

    public function children(): CategoryFilter
    {
        $this->children = true;
        return $this;
    }

    public function hasLimitOffset(): bool
    {
        return null !== $this->limitOffset;
    }

    public function getExcludeIds(): array
    {
        return $this->excludeIds;
    }

    public function addExcludeId(int $id): self
    {
        $this->excludeIds[] = $id;
        return $this;
    }
}
