<?php namespace Arcanedev\Support\Providers;

use Arcanedev\Support\Exceptions\RouteNamespaceUndefinedException;
use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanedev\Support\Laravel\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @method   Router  middleware(\string $name, \string $class)  Register a short-hand name for a middleware.
 */
abstract class RouteServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The Route Registrar instance.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    private $router;

    /**
     * Route collection.
     *
     * @var array
     */
    private $routes = [];

    /**
     * Routes path.
     *
     * @var string
     */
    protected $routesPath  = '../Http/Routes';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set the Router.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     *
     * @return self
     */
    private function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Get the routes namespace.
     *
     * @return string
     *
     * @throws \Arcanedev\Support\Exceptions\RouteNamespaceUndefinedException
     */
    protected function getRouteNamespace()
    {
        throw new RouteNamespaceUndefinedException(
            'The routes namespace is undefined.'
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    abstract public function map(Router $router);

    /**
     * Map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @param  string                                   $directory
     * @param  array                                    $attributes
     */
    protected function mapRoutes(Router $router, $directory, array $attributes = [])
    {
        $this->setRouter($router);
        $this->registerRoutes($directory);

        $this->router->group($attributes, function () {
            foreach ($this->routes as $route) {
                $this->app->make($route)->map($this->router);
            }
        });
    }

    /**
     * Register Routes.
     *
     * @param  string  $directory
     */
    protected function registerRoutes($directory)
    {
        $di = new RecursiveDirectoryIterator(
            $directory . DS . $this->routesPath,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        foreach(new RecursiveIteratorIterator($di) as $file) {
            /** @var SplFileInfo $file */
            $this->addRouteFromFile($file);
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add route from file.
     *
     * @param  SplFileInfo  $file
     */
    private function addRouteFromFile(SplFileInfo $file)
    {
        if (
            ! $file->isFile() ||
            pathinfo($file, PATHINFO_EXTENSION) !== 'php'
        ) return;

        $routeFolder = 'Routes' . DS;
        $pos         = strpos($file->getRealPath(), $routeFolder);

        if ($pos !== false) {
            $route  = substr(
                str_replace('.php', '', $file->getRealPath()),
                $pos + strlen($routeFolder)
            );
            $this->addRoute($route);
        }
    }

    /**
     * Add route to collection.
     *
     * @param  string  $route
     *
     * @return self
     */
    private function addRoute($route)
    {
        $this->routes[] = $this->getRouteNamespace() . '\\' . $route;

        return $this;
    }
}
