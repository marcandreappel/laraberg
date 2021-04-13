<?php

namespace MarcAndreAppel\Laraberg\Test;

use Illuminate\Foundation\Application;
use MarcAndreAppel\Laraberg\LarabergServiceProvider;
use Orchestra\Testbench\Testcase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  Application $app
     * @return MarcAndreAppel\Laraberg\LarabergServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [LarabergServiceProvider::class];
    }
}

