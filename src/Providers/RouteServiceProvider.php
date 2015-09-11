<?php namespace Arcanedev\Support\Providers;

use Exception;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
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
    /** @var Router */
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
     * Get the routes namespace
     *
     * @return string
     */
    abstract protected function getRouteNamespace();

    /**
     * Set the Router
     *
     * @param  Router  $router
     *
     * @return self
     */
    private function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the routes for the application.
     *
     * @param  Router  $router
     */
    abstract public function map(Router $router);

    /**
     * Map routes
     *
     * @param  Router  $router
     * @param  string  $directory
     * @param  array   $attributes
     */
    protected function mapRoutes(Router $router, $directory, array $attributes = [])
    {
        $this->checkRouteNamespace();
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
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check the route namespace
     *
     * @throws Exception
     */
    private function checkRouteNamespace()
    {
        $namespace = $this->getRouteNamespace();

        if (empty($namespace)) {
            throw new Exception('The routes namespace is empty.');
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
     * Add route to collection
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
