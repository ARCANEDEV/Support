<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests;

use Arcanedev\Support\Stub;
use Illuminate\Support\Str;

/**
 * Class     StubTest
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StubTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Support\Stub */
    private $stub;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp(): void
    {
        parent::setUp();

        //
    }

    public function tearDown(): void
    {
        unset($this->stub);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $this->stub = new Stub(
            $file = $this->getFixturesPath('stubs/composer.stub')
        );

        static::assertInstanceOf(\Arcanedev\Support\Stub::class, $this->stub);

        $fileContent = file_get_contents($file);

        static::assertEquals($fileContent, $this->stub->render());
        static::assertEquals($fileContent, (string) $this->stub);
    }

    /** @test */
    public function it_can_create(): void
    {
        Stub::setBasePath(
            $basePath = $this->getFixturesPath('stubs')
        );

        $this->stub = Stub::create('composer.stub');

        $this->stub->replaces([
            'VENDOR'            => 'arcanedev',
            'PACKAGE'           => 'package',
            'AUTHOR_NAME'       => 'ARCANEDEV',
            'AUTHOR_EMAIL'      => 'arcanedev.maroc@gmail.com',
            'MODULE_NAMESPACE'  => Str::studly('arcanedev'),
            'STUDLY_NAME'       => Str::studly('package'),
        ]);

        $this->stub->save('composer.json');

        $fixture = $this->getFixturesPath('stubs/composer.json');

        static::assertEquals(file_get_contents($fixture),$this->stub->render());

        $this->stub->saveTo($basePath, 'composer.json');

        static::assertEquals(file_get_contents($fixture), $this->stub->render());
    }

    /** @test */
    public function it_can_set_and_get_base_path(): void
    {
        Stub::setBasePath(
            $basePath = $this->getFixturesPath('stubs')
        );

        static::assertEquals($basePath, Stub::getBasePath());
    }

    /** @test */
    public function it_can_create_from_path(): void
    {
        $this->stub = Stub::createFromPath(
            $path = $this->getFixturesPath('stubs').'/composer.stub'
        );

        static::assertEmpty($this->stub->getBasePath());
        static::assertEquals($path, $this->stub->getPath());
        static::assertEmpty($this->stub->getReplaces());
    }
}
