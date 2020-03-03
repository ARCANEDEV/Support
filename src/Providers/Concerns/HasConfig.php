<?php

declare(strict_types=1);

namespace Arcanedev\Support\Providers\Concerns;

use Illuminate\Support\Str;

/**
 * Trait     HasConfig
 *
 * @package  Arcanedev\Support\Providers\Concerns
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait HasConfig
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = false;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get config folder.
     *
     * @return string
     */
    protected function getConfigFolder(): string
    {
        return realpath($this->getBasePath().DIRECTORY_SEPARATOR.'config');
    }

    /**
     * Get config key.
     *
     * @return string
     */
    protected function getConfigKey(): string
    {
        return Str::slug($this->package);
    }

    /**
     * Get config file path.
     *
     * @return string
     */
    protected function getConfigFile(): string
    {
        return $this->getConfigFolder().DIRECTORY_SEPARATOR."{$this->package}.php";
    }

    /**
     * Register configs.
     *
     * @param  string  $separator
     */
    protected function registerConfig(string $separator = '.'): void
    {
        $this->multiConfigs
            ? $this->registerMultipleConfigs($separator)
            : $this->mergeConfigFrom($this->getConfigFile(), $this->getConfigKey());
    }

    /**
     * Register all package configs.
     *
     * @param  string  $separator
     */
    private function registerMultipleConfigs(string $separator = '.'): void
    {
        foreach (glob($this->getConfigFolder().'/*.php') as $configPath) {
            $this->mergeConfigFrom(
                $configPath, $this->getConfigKey().$separator.basename($configPath, '.php')
            );
        }
    }

    /**
     * Publish the config file.
     *
     * @param  string|null  $path
     */
    protected function publishConfig(?string $path = null): void
    {
        $this->publishes([
            $this->getConfigFile() => $path ?: config_path("{$this->package}.php"),
        ], [$this->package, 'config', "{$this->package}-config"]);
    }
}
