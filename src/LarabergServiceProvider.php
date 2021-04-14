<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg;

use Illuminate\Support\ServiceProvider;

class LarabergServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/laraberg.php' => config_path('laraberg.php')], 'config');
        require __DIR__ . '/Http/routes.php';
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([__DIR__ . '/../public' => public_path('vendor/laraberg')], 'public');
    }

//    public function register()
//    {
//        $this->app->singleton(Laraberg::class, function () {
//            return new Laraberg();
//        });
//        $this->app->alias(Laraberg::class, 'laraberg');
//    }
}
