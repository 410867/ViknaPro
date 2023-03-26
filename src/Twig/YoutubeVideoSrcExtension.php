<?php

namespace App\Twig;

use Generator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class YoutubeVideoSrcExtension extends AbstractExtension
{
    public function getFilters(): array|Generator
    {
        yield new TwigFilter('app_youtube_video_id', fn(null|string $url) => $this->getYoutubeVideoSrc($url));
    }

    private function getYoutubeVideoSrc(null|string $url): null|string
    {
        if (empty($url)){
            return null;
        }

        $queryString = [];
        parse_str(parse_url($url, PHP_URL_QUERY), $queryString);

        if(!empty($queryString['v'])){
            return $queryString['v'];
        }

        $replacement = ['https://www.youtube.com/embed/', 'https://www.youtube.com/'];

        return str_replace($replacement, '', $url);
    }
}