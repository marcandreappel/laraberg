<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Helpers;

use Embed\Adapters\Adapter;
use Embed\Embed;

class EmbedHelper
{
    public static function renderEmbeds(string $html): string
    {
        // Match URL from raw Gutenberg embed content
        $regex = '/<!-- wp:core-embed\/.*?-->\s*?<figure class="wp-block-embed.*?".*?<div class="wp-block-embed__wrapper">\s*?(.*?)\s*?<\/div>.*?<\/figure>/';
        $result = preg_replace_callback($regex, function ($matches) {
            $embed = self::create($matches[1]);
            $url = preg_replace('/\//', '\/', preg_quote($matches[1]));
            // Replace URL with OEmbed HTML
            return preg_replace("/>\s*?$url\s*?</", ">$embed->code<", $matches[0]);
        }, $html);
        return $result;
    }

    public static function serialize(object $embed): array
    {
        return [
            'url' => $embed->url,
            'author_name' => $embed->authorName,
            'author_url' => $embed->authorUrl,
            'html' => $embed->code,
            'width' => $embed->width,
            'height' => $embed->height,
            'type' => $embed->type,
            'provider_name' => $embed->providerName,
            'provider_url' => $embed->providerUrl
        ];
    }

    public static function create(string $url): Adapter
    {
        return Embed::create($url);
    }
}

