<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests\Providers;

use Arcanedev\Support\Exceptions\PackageException;
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

    /** @var  \Arcanedev\Support\Tests\Stubs\TestPackageServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = new TestPackageServiceProvider($this->app);

        $this->provider->register();
    }

    public function tearDown(): void
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\Providers\ServiceProvider::class,
            \Arcanedev\Support\Providers\PackageServiceProvider::class,
            \Arcanedev\Support\Tests\Stubs\TestPackageServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_register_config(): void
    {
        $config = config('package');

        static::assertArrayHasKey('foo', $config);
        static::assertEquals($config['foo'], 'bar');
    }

    /** @test */
    public function it_must_throw_a_package_exception(): void
    {
        $this->expectException(PackageException::class);
        $this->expectExceptionMessage('You must specify the vendor/package name.');

        (new InvalidPackageServiceProvider($this->app))->register();
    }
}
