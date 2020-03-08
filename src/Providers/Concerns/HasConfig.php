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
        return Str::slug($this->getPackageName());
    }

    /**
     * Get config file path.
     *
     * @return string
     */
    protected function getConfigFile(): string
    {
        return $this->getConfigFolder().DIRECTORY_SEPARATOR."{$this->getPackageName()}.php";
    }

    /**
     * Get the config files (paths).
     *
     * @return array|false
     */
    protected function configFilesPaths()
    {
        return glob($this->getConfigFolder().DIRECTORY_SEPARATOR.'*.php');
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
            : $this->registerSingleConfig();
    }

    /**
     * Register a single config file.
     */
    protected function registerSingleConfig(): void
    {
        $this->mergeConfigFrom($this->getConfigFile(), $this->getConfigKey());
    }

    /**
     * Register all package configs.
     *
     * @param  string  $separator
     */
    protected function registerMultipleConfigs(string $separator = '.'): void
    {
        foreach ($this->configFilesPaths() as $configPath) {
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
        $this->multiConfigs
            ? $this->publishMultipleConfigs()
            : $this->publishSingleConfig($path);
    }

    /**
     * Publish a single config file.
     *
     * @param  string|null  $path
     */
    protected function publishSingleConfig(?string $path = null): void
    {
        $this->publishes([
            $this->getConfigFile() => $path ?: config_path("{$this->getPackageName()}.php"),
        ], $this->getPublishedTags('config'));
    }

    /**
     * Publish multiple config files.
     */
    protected function publishMultipleConfigs(): void
    {
        $paths   = [];
        $package = $this->getVendorName().DIRECTORY_SEPARATOR.$this->getPackageName();

        foreach ($this->configFilesPaths() as $file) {
            $paths[$file] = config_path($package.DIRECTORY_SEPARATOR.basename($file));
        }

        $this->publishes($paths, $this->getPublishedTags('config'));
    }
}
