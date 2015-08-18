<?php namespace Arcanedev\Support\Laravel;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class ServiceProvider
 * @package Arcanedev\Foundation\Bases
 */
abstract class ServiceProvider extends IlluminateServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add Aliases into the app
     *
     * @param  array $aliases
     *
     * @return self
     */
    protected function addAliases(array $aliases)
    {
        if (count($aliases)) {
            $loader = AliasLoader::getInstance();

            foreach ($aliases as $alias => $class) {
                $loader->alias($alias, $class);
            }
        }

        return $this;
    }
}
