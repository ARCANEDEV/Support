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
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Arcanedev\Support\Tests\Stubs\TestPackageServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->provider = new TestPackageServiceProvider($this->app);

        $this->provider->register();
    }

    public function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\Support\Tests\Stubs\TestPackageServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
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
     * @expectedExceptionMessage  You must specify the vendor/package name.
     */
    public function it_must_throw_a_package_exception()
    {
        (new InvalidPackageServiceProvider($this->app))->register();
    }
}
