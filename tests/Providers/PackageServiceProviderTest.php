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
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var TestPackageServiceProvider
     */
    private $provider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = new TestPackageServiceProvider($this->app);

        $this->provider->register();
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->provider);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(
            'Arcanedev\\Support\\Tests\\Stubs\\TestPackageServiceProvider',
            $this->provider
        );

        $this->assertInstanceOf(
            'Arcanedev\\Support\\PackageServiceProvider',
            $this->provider
        );

        $this->assertInstanceOf(
            'Arcanedev\\Support\\ServiceProvider',
            $this->provider
        );

        $this->assertInstanceOf(
            '\Illuminate\\Support\\ServiceProvider',
            $this->provider
        );
    }

    /** @test */
    public function it_can_register_config()
    {
        $config = config('package');

        $this->assertArrayHasKey('foo', $config);
        $this->assertEquals($config['foo'], 'bar');
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
