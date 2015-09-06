<?php namespace Arcanedev\Support\Laravel;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use ReflectionClass;

/**
 * Class     PackageServiceProvider
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * Package path.
     *
     * @var string
     */
    protected $packagePath = '';

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
     * Get package base path.
     *
     * @return string
     */
    protected function getPackagePath()
    {
        return $this->packagePath;
    }

    /**
     * Set package path.
     *
     * @return self
     */
    private function setPackagePath()
    {
        $path = (new ReflectionClass(get_class($this)))
            ->getFileName();

        $this->packagePath = dirname(dirname($path));

        return $this;
    }

    /**
     * Get config path.
     *
     * @return string
     */
    public function getConfigPath()
    {
        return $this->getPackagePath() . '/config';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->setPackagePath();
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
            throw new Exception(
                'You must specify the name of the package'
            );
        }
    }

    /**
     * Setup package path and stuff.
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
     * Register all package configs.
     *
     * @return self
     */
    protected function registerConfigs()
    {
        $paths = glob($this->packagePath . '/config/*.php');

        foreach ($paths as $path) {
            $key = $this->package . '.' . basename($path, '.php');
            $this->mergeConfigFrom($path, $key);
        }

        return $this;
    }

    /**
     * Setup paths.
     *
     * @param  string  $path
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
