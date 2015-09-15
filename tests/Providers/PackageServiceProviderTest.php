<?php namespace Arcanedev\Support\Tests\Providers;

use Arcanedev\Support\Tests\Stubs\InvalidPackageServiceProvider;
use Arcanedev\Support\Tests\Stubs\TestPackageServiceProvider;
use Arcanedev\Support\Tests\TestCase;

/**
 * Class     PackageServiceProviderTest
 *
 * @package  Arcanedev\Support\Tests\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PackageServiceProviderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $provider = new TestPackageServiceProvider($this->app);

        $provider->register();
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Support\Exceptions\PackageException
     * @expectedExceptionMessage  You must specify the name of the package
     */
    public function it_must_throw_a_package_exception()
    {
        (new InvalidPackageServiceProvider($this->app))->register();
    }
}
