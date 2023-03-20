<?php

namespace App\Object;

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

    /**
     * Builds the array for each page.
     *
     * @param string $page
     * @param string $url
     * @param string $text
     * @param string $status
     *
     * @return array
     */
    protected function pageArray($page, $text, $context = 'page')
    {
        return [
            'page' => $page,
            'text' => $text,
            'context' => ($this->page == $page) ? 'current' : $context
        ];
    }

    public function getTotalPages(): int
    {
        return $this->limit != 0 ? ceil($this->totalItems / $this->limit) : 0;
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

    /**
     * @return array
     */
    protected function getPages(): array
    {
        if ($this->getTotalPages() <= 1) {
            return [];
        }


        $startOffset = ($this->page - self::PAGES_AROUND_ACTIVE) > 0 ? $this->page - self::PAGES_AROUND_ACTIVE : self::FIRST_PAGE;
        $endOffset = ($this->page + self::PAGES_AROUND_ACTIVE) < $this->total_pages ? $this->page + self::PAGES_AROUND_ACTIVE : $this->last_page;


        if (((self::PAGES_BEFORE_SEPARATOR * 2) + self::PAGES_BEFORE_SEPARATOR) >= $this->getTotalPages()) {
            $hideSeparator = true;
        }

        if (!$this->hide_previous) {
            if ($this->prev_page) {
                $this->pages[] = $this->pageArray($this->prev_page, $this->previous_text, 'prev');
            }
        }
        if ($this->start_offset >= $this->pagesBeforeSeparator) {
            for ($i = 1; $i <= $this->pagesBeforeSeparator; $i++) {
                $this->pages[] = $this->pageArray($i, $this->pageText($i));
                $pages[] = $i;
            }

            if (!$this->hide_separator) {
                $this->pages[] = $this->pageArray(null, $this->separator, 'separator');
            }
        }

        for ($i = $this->start_offset; $i <= $this->end_offset; $i++) {
            if (!in_array($i, $pages)) {
                $this->pages[] = $this->pageArray($i, $this->pageText($i));
            }
        }

        if ($this->end_offset <= ($this->last_page - $this->pagesBeforeSeparator)) {
            if (!$this->hide_separator) {
                $this->pages[] = $this->pageArray(null, $this->separator, 'separator');
            }

            for ($i = ($this->last_page - ($this->pagesBeforeSeparator - 1)); $i <= $this->last_page; $i++) {
                $this->pages[] = $this->pageArray($i, $this->pageText($i));
            }
        }

        if ($i == $this->last_page) {
            $this->pages[] = $this->pageArray($i, $this->pageText($i));
        }

        if (!$this->hide_next) {
            if ($this->next_page) {
                $this->pages[] = $this->pageArray($this->next_page, $this->next_text, 'next');
            }
        }

        return $this->pages;
    }

    /**
     * Generates and returns the generated pagination structure.
     *
     * @return string The pagination structure.
     */
    public function get()
    {
        if ($this->pages === null) {
            $this->generate();
        }

        $navigation_id = $this->navigation_id ? ' id="' . $this->navigation_id . '"' : '';

        $output = '<nav' . $navigation_id . ' class="' . $this->size . '" aria-label="Navigation">';
        $output .= "\r\n";
        $output .= '<ul class="pagination ' . $this->align . '">';
        $output .= "\r\n";
        foreach ($this->pages as $page) {
            $page_item_class = $page['page'] ? $page['page'] : 'separator';
            $page_link_class = $page['page'] ? $page['page'] : 'separator';
            $page_disabled_class = !$page['page'] ? ' disabled' : '';

            switch ($page['context']) {
                case 'prev':
                    $output .= '<li class="page-item page-item-' . $page_item_class . ' page-prev' . $page_disabled_class . '">';
                    $output .= '<a aria-label="' . $page['text'] . '" class="page-link page-link-' . $page_link_class . ' page-link-prev" href="' . $page['url'] . '">';
                    $output .= '<span aria-hidden="true">' . $page['text'] . '</span>';
                    if ($this->screen_reader) {
                        $output .= '<span class="sr-only">' . $page['text'] . '</span>';
                    }
                    $output .= '</a>';
                    $output .= '</li>';
                    break;
                case 'next':
                    $output .= '<li class="page-item page-item-' . $page_item_class . ' page-next' . $page_disabled_class . '">';
                    $output .= '<a aria-label="' . $page['text'] . '" class="page-link page-link-' . $page_link_class . ' page-link-next" href="' . $page['url'] . '">';
                    $output .= '<span aria-hidden="true">' . $page['text'] . '</span>';
                    if ($this->screen_reader) {
                        $output .= '<span class="sr-only">' . $page['text'] . '</span>';
                    }
                    $output .= '</a>';
                    $output .= '</li>';
                    break;
                case 'separator':
                    $output .= '<li class="page-item page-item-' . $page_item_class . ' disabled">';
                    $output .= '<span class="page-link">' . $page['text'] . '</span>';
                    if ($this->screen_reader) {
                        $output .= '<span class="sr-only">(separator)</span>';
                    }
                    $output .= '</li>';
                    break;
                case 'current':
                    $output .= '<li class="page-item page-item-' . $page_item_class . ' active">';
                    $output .= '<span class="page-link">' . $page['text'] . '</span>';
                    $output .= '</li>';
                    break;
                case 'page':
                    $output .= '<li class="page-item page-item-' . $page_item_class . '">';
                    $output .= '<a class="page-link page-link-' . $page_link_class . '" href="' . $page['url'] . '">' . $page['text'] . '</a>';
                    $output .= '</li>';
                    break;
            }

            $output .= "\r\n";
        }

        $output .= '</ul>';
        $output .= "\r\n";
        $output .= '</nav>';
        $output .= "\r\n";

        $this->pagination = $output;

        return $this->pagination;
    }
}
