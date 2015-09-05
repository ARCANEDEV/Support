<?php namespace Arcanedev\Support\Laravel\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
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
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Routes.
     *
     * @param  string  $directory
     *
     * @return array
     */
    protected function registerRoutes($directory)
    {
        $di     = new RecursiveDirectoryIterator(
            $directory,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        foreach(new RecursiveIteratorIterator($di) as $file) {
            $this->addRouteFromFile($file);
        }

        return $this->routes;
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
        if (
            $file->isFile() &&
            pathinfo($file, PATHINFO_EXTENSION) === 'php'
        ) {
            $pos = strpos($file->getRealPath(), $needle);

            if ($pos !== false) {
                $path           = str_replace('.php', '', $file->getRealPath());
                $route          = substr($path, $pos + strlen($needle));
                $this->routes[] = $this->namespace . '\\' . $route;
            }
        }
    }
}
