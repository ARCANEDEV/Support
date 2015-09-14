<?php namespace Arcanedev\Support\Providers;

use Arcanedev\Support\ServiceProvider;
use Closure;

/**
 * Class     CommandServiceProvider
 *
 * @package  Arcanedev\Support\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class CommandServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor   = '';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package  = '';

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->commands($this->commands);
    }

    /**
     * Get the provided commands.
     *
     * @return array
     */
    public function provides()
    {
        return $this->commands;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get abstract command name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getAbstractCommandName($name)
    {
        return "{$this->vendor}.{$this->package}.commands.$name";
    }

    /**
     * Register a command.
     *
     * @param  string   $name
     * @param  Closure  $callback
     */
    protected function registerCommand($name, Closure $callback)
    {
        $command = $this->getAbstractCommandName($name);

        $this->singleton($command, $callback);

        $this->commands[] = $command;
    }
}
