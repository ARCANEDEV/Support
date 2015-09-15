<?php namespace Arcanedev\Support\Tests\Stubs;

use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     InvalidPackageServiceProvider
 *
 * @package  Arcanedev\Support\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidPackageServiceProvider extends PackageServiceProvider
{
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setup();
    }
}
