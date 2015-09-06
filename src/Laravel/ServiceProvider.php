<?php namespace Arcanedev\Support\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class     ServiceProvider
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class ServiceProvider extends IlluminateServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Alias loader
     *
     * @var AliasLoader
     */
    private $aliasLoader;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new service provider instance.
     *
     * @param  Application  $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->aliasLoader = AliasLoader::getInstance();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add Aliases into the app
     *
     * @param  array  $aliases
     *
     * @return self
     */
    protected function addFacades(array $aliases)
    {
        foreach ($aliases as $alias => $facade) {
            $this->addFacade($alias, $facade);
        }

        return $this;
    }

    /**
     * Add Alias (Facade)
     *
     * @param  string  $alias
     * @param  string  $facade
     */
    protected function addFacade($alias, $facade)
    {
        $this->aliasLoader->alias($alias, $facade);
    }
}
