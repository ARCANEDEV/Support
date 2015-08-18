<?php namespace Arcanedev\Support\Laravel;

use ReflectionClass;

/**
 * Class PackageServiceProvider
 * @package Arcanedev\Moduly\Bases
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name
     *
     * @var string
     */
    protected $package = '';

    /**
     * Paths collection
     *
     * @var array
     */
    protected $paths = [];

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get package base path
     *
     * @return string
     */
    protected function getPackagePath()
    {
        $path = (new ReflectionClass(get_class($this)))
            ->getFileName();

        return dirname(dirname($path));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function boot()
    {
        if (empty($this->package) ) {
            throw new \Exception('You must specify the name of the package');
        }
    }

    /**
     * Setup package
     *
     * @param  string $path
     *
     * @return self
     */
    public function setup($path)
    {
        $this->setupPaths($path);

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register all package configs
     *
     * @return self
     */
    protected function registerConfigs()
    {
        array_map(function ($path) {
            $this->mergeConfig($path);
        }, glob($this->getPackagePath() . '/config/*.php'));

        return $this;
    }

    /**
     * Merge config files
     *
     * @param  string $path
     *
     * @return self
     */
    private function mergeConfig($path)
    {
        $this->mergeConfigFrom($path,
            $this->package . '.' . basename($path, '.php')
        );

        return $this;
    }

    /**
     * Setup paths
     *
     * @param  string $path
     *
     * @return self
     */
    private function setupPaths($path)
    {
        $this->paths = [
            'migrations' => [
                'src'       => $path . '/../database/migrations',
                'dest'      => database_path('/migrations/%s_%s'),
            ],
            'seeds'     => [
                'src'       => $path . '/Seeds',
                'dest'      => database_path('/seeds/%s'),
            ],
            'config'    => [
                'src'       => $path . '/../config',
                'dest'      => config_path('%s'),
            ],
            'views'     => [
                'src'       => $path . '/../resources/views',
                'dest'      => base_path('resources/views/vendor/%s'),
            ],
            'trans'     => [
                'src'       => $path . '/../resources/lang',
                'dest'      => base_path('resources/lang/%s'),
            ],
            'assets'    => [
                'src'       => $path . '/../resources/assets',
                'dest'      => public_path('vendor/%s'),
            ],
            'routes' => [
                'src'       => $path . '/../start/routes.php',
                'dest'      => null,
            ],
        ];

        return $this;
    }
}
