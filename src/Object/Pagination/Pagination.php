<?php

namespace App\Object\Pagination;

use App\Object\LimitOffset;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class Pagination
{
    private const PAGES_BEFORE_SEPARATOR = 2;
    private const PAGES_AROUND_ACTIVE = 2;
    private const FIRST_PAGE = 1;

    protected int $totalItems;
    protected int $page;
    protected int $limit;

    public function __construct(int $page, int $limit, int $totalItems)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->totalItems = $totalItems;
    }

    public static function newFromPaginator(Paginator $paginator, LimitOffset $limitOffset): Pagination
    {
        return new self(
            page: $limitOffset->getPage(),
            limit: $limitOffset->getLimit(),
            totalItems: $paginator->count()
        );
    }

    public function getTotalPages(): int
    {
        return $this->limit != 0 ? ceil($this->totalItems / $this->limit) : 0;
    }

    public function hasPages(): bool
    {
        return $this->getTotalPages() > 1;
    }

    public function getPrev(): int
    {
        return max($this->page - 1, 0);
    }

    public function getNext(): int
    {
        $nextPage = $this->page + 1;
        return $nextPage <= $this->getTotalPages() ? $nextPage : 0;
    }

    // todo: refactor. https://github.com/benhall14/php-pagination/blob/master/src/PHPPagination/Pagination.php
    /**
     * @return array<Page>
     */
    public function getPages(): array
    {
        if ($this->page > $this->getTotalPages()){
            throw new NotFoundHttpException('Page is not valid');
        }

        if ($this->getTotalPages() <= 1) {
            return [];
        }

        $startOffset = ($this->page - self::PAGES_AROUND_ACTIVE) > 0 ? $this->page - self::PAGES_AROUND_ACTIVE : self::FIRST_PAGE;
        $endOffset = ($this->page + self::PAGES_AROUND_ACTIVE) < $this->getTotalPages() ? $this->page + self::PAGES_AROUND_ACTIVE : $this->getTotalPages();

        if (((self::PAGES_BEFORE_SEPARATOR * 2) + self::PAGES_BEFORE_SEPARATOR) >= $this->getTotalPages()) {
            $hideSeparator = true;
        } else {
            $hideSeparator = false;
        }

        $pages = [];
        $result = [];
        if ($startOffset >= self::PAGES_BEFORE_SEPARATOR) {
            for ($i = 1; $i <= self::PAGES_BEFORE_SEPARATOR; $i++) {
                $result[] = Page::newPage($i, $i === $this->page);
                $pages[] = $i;
            }
            if (!$hideSeparator) {
                $result[] = Page::newSeparator();
            }
        }

        for ($i = $startOffset; $i <= $endOffset; $i++) {
            if (!in_array($i, $pages)) {
                $result[] = Page::newPage($i, $i === $this->page);
            }
        }

        if ($endOffset <= ($this->getTotalPages() - self::PAGES_BEFORE_SEPARATOR)) {
            if (!$hideSeparator) {
                $result[] = Page::newSeparator();
            }

            for ($i = ($this->getTotalPages() - (self::PAGES_BEFORE_SEPARATOR - 1)); $i <= $this->getTotalPages(); $i++) {
                $result[] = Page::newPage($i, $i === $this->page);
            }
        }

        if ($i == $this->getTotalPages()) {
            $result[] = Page::newPage($i, $i === $this->page);
        }

        return $result;
    }
}
