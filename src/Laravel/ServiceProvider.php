<?php namespace Arcanedev\Support\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class ServiceProvider
 * @package Arcanedev\Foundation\Bases
 */
abstract class ServiceProvider extends IlluminateServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add Aliases into the app
     *
     * @param  array  $aliases
     *
     * @return self
     */
    protected function addAliases(array $aliases)
    {
        foreach ($aliases as $alias => $facade) {
            $this->addAlias($alias, $facade);
        }

        return $this;
    }

    /**
     * Add Alias (Facade)
     *
     * @param  string  $alias
     * @param  string  $facade
     */
    protected function addAlias($alias, $facade)
    {
        $this->aliasLoader->alias($alias, $facade);
    }
}
