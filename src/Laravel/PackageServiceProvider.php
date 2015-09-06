<?php namespace Arcanedev\Support\Laravel;

use Exception;

/**
 * Class     PackageServiceProvider
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo     Redo the PackageServiceProvider
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = '';

    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor  = 'vendor';

    /**
     * Paths collection.
     *
     * @var array
     */
    protected $paths = [];

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get config folder.
     *
     * @return string
     */
    public function getConfigFolder()
    {
        return realpath($this->getBasePath() . '/config');
    }

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    abstract public function getBasePath();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Boot the package.
     *
     * @throws Exception
     */
    public function boot()
    {
        if (empty($this->package) ) {
            throw new Exception('You must specify the name of the package');
        }
    }

    /**
     * Setup package path and stuff.
     *
     * @return self
     */
    public function setup()
    {
        $this->setupPaths();

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register all package configs.
     *
     * @return self
     */
    protected function registerConfigs()
    {
        $paths = glob($this->getConfigFolder() . '/*.php');

        foreach ($paths as $path) {
            $key = $this->package . '.' . basename($path, '.php');
            $this->mergeConfigFrom($path, $key);
        }

        return $this;
    }

    /**
     * Setup paths.
     *
     * @return self
     */
    private function setupPaths()
    {
        $path = $this->getBasePath();

        $this->paths = [
            'migrations' => [
                'src'       => $path . '/database/migrations',
                'dest'      => database_path('/migrations/%s_%s'),
            ],
            'seeds'     => [
                'src'       => $path . '/src/Seeds',
                'dest'      => database_path('/seeds/%s'),
            ],
            'config'    => [
                'src'       => $path . '/config',
                'dest'      => config_path('%s'),
            ],
            'views'     => [
                'src'       => $path . '/resources/views',
                'dest'      => base_path('resources/views/' . $this->vendor . '/%s'),
            ],
            'trans'     => [
                'src'       => $path . '/resources/lang',
                'dest'      => base_path('resources/lang/%s'),
            ],
            'assets'    => [
                'src'       => $path . '/resources/assets',
                'dest'      => public_path('vendor/%s'),
            ],
            'routes' => [
                'src'       => $path . '/start/routes.php',
                'dest'      => null,
            ],
        ];

        return $this;
    }
}
