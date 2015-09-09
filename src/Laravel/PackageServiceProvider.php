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
    protected $package      = '';

    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor       = 'vendor';

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = false;

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

    /**
     * Get config file path
     *
     * @return string
     */
    protected function getConfigFile()
    {
        return realpath($this->getBasePath() . "/config/{$this->package}.php");
    }

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
    protected function setup()
    {
        $this->setupPaths();

        if ($this->multiConfigs) {
            $this->registerMultipleConfigs();
        }

        return $this;
    }

    /**
     * Register configs.
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom($this->getConfigFile(), $this->package);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register all package configs.
     *
     * @param  string  $separator
     */
    private function registerMultipleConfigs($separator = '.')
    {
        array_map(function ($configPath) use ($separator) {
            $this->mergeConfigFrom(
                $configPath,
                $this->package . $separator . basename($configPath, '.php')
            );

        }, glob($this->getConfigFolder() . '/*.php'));
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
