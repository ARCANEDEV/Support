<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $this->registerRoutes($app['router']);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get fixture path
     *
     * @param  string  $path
     *
     * @return string
     */
    protected function getFixturesPath(string $path): string
    {
        return __DIR__.'/fixtures/'.$path;
    }

    /**
     * Register the routes.
     *
     * @param \Illuminate\Routing\Router $router
     */
    private function registerRoutes(Router $router): void
    {

    }
}
