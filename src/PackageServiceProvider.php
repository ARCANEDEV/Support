<?php namespace Arcanedev\Support;

use Arcanedev\Support\Exceptions\PackageException;

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
     * Package base path.
     *
     * @var string
     */
    protected $basePath     = '';

    /**
     * Paths collection.
     *
     * @var array
     */
    protected $paths        = [];

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     *
     * @todo: complete the implementation.
     */
    protected $multiConfigs = false;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get config folder.
     *
     * @return string
     */
    protected function getConfigFolder()
    {
        return realpath($this->getBasePath() . DS .'config');
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
        return $this->getConfigFolder() . DS . $this->package . '.php';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Boot the package.
     */
    public function boot()
    {
        $this->checkPackageName();
    }

    /**
     * Setup package path and stuff.
     */
    protected function setup()
    {
        $this->checkPackageName();
        $this->setupPaths();

        if ($this->multiConfigs) {
            $this->registerMultipleConfigs();
        }
    }

    /**
     * Register configs.
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom($this->getConfigFile(), $this->package);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check package name
     *
     * @throws PackageException
     */
    private function checkPackageName()
    {
        if (empty($this->package) ) {
            throw new PackageException(
                'You must specify the name of the package'
            );
        }
    }

    /**
     * Check if has the base config.
     *
     * @return bool
     */
    protected function hasPackageConfig()
    {
        return $this->getConfigFile() !== false;
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
        $this->basePath = $this->getBasePath();

        $this->paths = [
            'migrations' => [
                'src'       => $this->getSourcePath('database/migrations'),
                'dest'      => database_path('migrations/%s_%s'),
            ],
            'seeds'     => [
                'src'       => $this->getSourcePath('src/Seeds'),
                'dest'      => database_path('seeds/%s'),
            ],
            'config'    => [
                'src'       => $this->getSourcePath('config'),
                'dest'      => config_path('%s'),
            ],
            'views'     => [
                'src'       => $this->getSourcePath('resources/views'),
                'dest'      => base_path('resources/views/' . $this->vendor . '/%s'),
            ],
            'trans'     => [
                'src'       => $this->getSourcePath('resources/lang'),
                'dest'      => base_path('resources/lang/%s'),
            ],
            'assets'    => [
                'src'       => $this->getSourcePath('resources/assets'),
                'dest'      => public_path('vendor/%s'),
            ],
            'routes' => [
                'src'       => $this->getSourcePath('start/routes.php'),
                'dest'      => null,
            ],
        ];

        return $this;
    }

    /**
     * Get source path.
     *
     * @param  string  $path
     *
     * @return string
     */
    private function getSourcePath($path)
    {
        return str_replace('/', DS, $this->basePath . DS . $path);
    }
}
