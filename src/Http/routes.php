<?php
declare(strict_types=1);

if (config('laraberg.use_package_routes')) {
    Route::group(['prefix' => config('laraberg.prefix'), 'middleware' => config('laraberg.middlewares')], function () {
        Route::apiResource('blocks', MarcAndreAppel\Laraberg\Http\Controllers\BlockController::class);
        Route::get('oembed', MarcAndreAppel\Laraberg\Http\Controllers\OEmbedController::class);
    });
}
