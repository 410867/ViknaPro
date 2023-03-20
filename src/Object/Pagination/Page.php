<?php

namespace App\Object\Pagination;

final class Page
{
    private ?int $page;
    private PageContextEnum $context;

    public function __construct(null|int $page, PageContextEnum $context)
    {
        $this->page = $page;
        $this->context = $context;
    }

    public static function newSeparator(): Page
    {
        return new self(null, PageContextEnum::SEPARATOR);
    }

    public static function newPage(int $page, bool $current): Page
    {
        return new self($page, $current ? PageContextEnum::CURRENT : PageContextEnum::PAGE);
    }

    public static function currentPage(int $page): Page
    {
        return new self($page, PageContextEnum::CURRENT);
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getContext(): PageContextEnum
    {
        return $this->context;
    }

    public function isCurrent(): bool
    {
        return $this->context === PageContextEnum::CURRENT;
    }

    public function isSeparator(): bool
    {
        return $this->context === PageContextEnum::SEPARATOR;
    }
}
