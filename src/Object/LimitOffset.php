<?php

namespace App\Object;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

final class LimitOffset implements FromRequestObjectInterface
{
    public const DEFAULT_LIMIT = 10;
    public const MAX_LIMIT = 100;
    public const PAGE_PARAM = 'page';

    #[GreaterThanOrEqual(1)]
    #[LessThanOrEqual(self::MAX_LIMIT)]
    private int $limit;

    #[GreaterThanOrEqual(0)]
    private int $offset;

    #[GreaterThanOrEqual(1)]
    private int $page;

    public static function newFromRequest(Request $request): static
    {
        $res = new self();
        $res->limit = $request->get('limit', self::DEFAULT_LIMIT);

        $res->page = (int)$request->get(self::PAGE_PARAM, 1);
        $res->page = $res->page > 0 ? $res->page : 1;

        $res->offset = ($res->page - 1) * $res->limit;

        return $res;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
