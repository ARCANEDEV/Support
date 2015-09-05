<?php namespace Arcanedev\Support\Laravel\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class RouteServiceProvider
 * @package Arcanedev\Foundation\Bases
 */
abstract class RouteServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Router */
    protected $router;

    /**
     * Route namespace.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * Route collection.
     *
     * @var array
     */
    protected $routes    = [];

    /**
     * Routes path.
     *
     * @var string
     */
    protected $routesPath  = '../Http/Routes';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new service provider instance.
     *
     * @param  Application  $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->routes = [];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
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
     * Boot the route service provider
     *
     * @param  Router  $router
     */
    public function boot(Router $router)
    {
        $this->setRouter($router);

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  Router  $router
     */
    abstract public function map(Router $router = null);

    /**
     * Map routes
     *
     * @param  string  $directory
     * @param  array   $attributes
     */
    protected function mapRoutes($directory, array $attributes = [])
    {
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
            $directory,
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
     * @param  string       $needle
     */
    private function addRouteFromFile(SplFileInfo $file, $needle = 'Routes\\')
    {
        if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $pos = strpos($file->getRealPath(), $needle);

            if ($pos !== false) {
                $route  = substr(
                    str_replace('.php', '', $file->getRealPath()),
                    $pos + strlen($needle)
                );
                $this->addRoute($route);
            }
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
        $this->routes[] = $this->namespace . '\\' . $route;

        return $this;
    }
}
