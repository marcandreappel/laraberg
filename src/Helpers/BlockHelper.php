<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Helpers;

use MarcAndreAppel\Laraberg\Models\Block;

class BlockHelper
{
    public static function renderBlocks(string $html): string
    {
        // Replace reusable block ID with reusable block HTML
        $regex = '/<!-- wp:block {"ref":(\d*)} \/-->/';

        return preg_replace_callback($regex, function ($matches) {
            return self::renderBlock($matches[1]);
        }, $html);
    }

    private static function renderBlock(string $id): string
    {
        $block = Block::where('id', $id)->first();

        if ($block) {
            return $block->render();
        } else {
            return __('Block not found');
        }
    }
}
