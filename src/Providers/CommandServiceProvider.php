<?php namespace Arcanedev\Support\Providers;

use Arcanedev\Support\Exceptions\PackageException;
use Arcanedev\Support\ServiceProvider;

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
    protected $vendor   = 'arcanedev';

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
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get command prefix name.
     *
     * @return string
     */
    protected function getCommandPrefix()
    {
        $this->checkPackageName();

        return empty($this->vendor)
            ? $this->package
            : "{$this->vendor}.{$this->package}";
    }

    /**
     * Get abstract command name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getAbstractCommandName($name)
    {
        return  $this->getCommandPrefix() . ".commands.$name";
    }

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

    /**
     * Register a command.
     *
     * @param  string                $name
     * @param  \Closure|string|null  $callback
     */
    protected function registerCommand($name, $callback)
    {
        $command = $this->getAbstractCommandName($name);

        $this->singleton($command, $callback);

        $this->commands[] = $command;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check the package name.
     *
     * @throws PackageException
     */
    private function checkPackageName()
    {
        if (empty($this->package)) {
            throw new PackageException('You must specify the package name.');
        }
    }
}
