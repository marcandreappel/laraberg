<?php
declare(strict_types=1);

return [
    'use_package_routes' => true,
    'middlewares' => ['web', 'auth'],
    'prefix' => 'laraberg',
    "models" => [
        "block"   => MarcAndreAppel\Laraberg\Models\Block::class,
        "content" => MarcAndreAppel\Laraberg\Models\Content::class,
    ],
];
