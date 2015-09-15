<?php namespace Arcanedev\Support\Tests\Stubs;

use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     TestPackageServiceProvider
 *
 * @package  Arcanedev\Support\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TestPackageServiceProvider extends PackageServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $vendor  = 'arcanedev';

    protected $package = 'name';

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
