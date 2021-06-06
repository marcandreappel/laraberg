<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Helpers;

use MarcAndreAppel\Laraberg\Contracts\TransformerContract;

class TransformerHelper
{
    public static function render(string $html): string
    {
        collect(config('laraberg.transformers'))
            ->map(function ($model) use (&$html) {
                $transformer = new $model;
                if ($transformer instanceof TransformerContract && method_exists($transformer, 'parse')) {
                    $html = $transformer->parse($html);
                }
            });

        return $html;
    }
}
