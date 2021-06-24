<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg;

use Illuminate\Support\ServiceProvider;

class LarabergServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishesToGroupes([
            __DIR__.'/config/laraberg.php' => config_path('laraberg.php')
        ], ['laraberg', 'laraberg:config']);

        require __DIR__.'/Http/routes.php';

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        
        $this->publishesToGroups([
            __DIR__.'/../public' => public_path('vendor/laraberg'),
        ], ['laraberg', 'laraberg:assets']);
    }

    protected function publishesToGroups(array $paths, $groups = null)
    {
        if (is_null($groups)) {
            $this->publishes($paths);

            return;
        }

        foreach ((array) $groups as $group) {
            $this->publishes($paths, $group);
        }
    }
}
