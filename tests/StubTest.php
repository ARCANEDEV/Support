<?php namespace Arcanedev\Support\Tests;

use Arcanedev\Support\Stub;

/**
 * Class     StubTest
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StubTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Stub */
    private $stub;

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
        unset($this->stub);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $file = $this->getFixturesPath('stubs/composer.stub');
        $this->stub = new Stub($file);

        $this->assertInstanceOf('Arcanedev\\Support\\Stub', $this->stub);
        $fileContent = file_get_contents($file);
        $this->assertEquals($fileContent, $this->stub->render());
        $this->assertEquals($fileContent, (string) $this->stub);
    }

    /** @test */
    public function it_can_create()
    {
        $basePath   = $this->getFixturesPath('stubs');
        Stub::setBasePath($basePath);

        $this->stub = Stub::create('composer.stub');

        $this->stub->replaces([
            'VENDOR'            => 'arcanedev',
            'PACKAGE'           => 'package',
            'AUTHOR_NAME'       => 'ARCANEDEV',
            'AUTHOR_EMAIL'      => 'arcanedev.maroc@gmail.com',
            'MODULE_NAMESPACE'  => str_studly('arcanedev'),
            'STUDLY_NAME'       => str_studly('package'),
        ]);

        $this->stub->save('composer.json');

        $fixture = $this->getFixturesPath('stubs/composer.json');

        $this->assertEquals(file_get_contents($fixture),$this->stub->render());

        $this->stub->saveTo($basePath, 'composer.json');

        $this->assertEquals(file_get_contents($fixture), $this->stub->render());
    }

    /** @test */
    public function it_can_set_and_get_base_path()
    {
        $basePath = $this->getFixturesPath('stubs');
        Stub::setBasePath($basePath);

        $this->assertEquals($basePath, Stub::getBasePath());
    }

    /** @test */
    public function it_can_create_from_path()
    {
        $path = $this->getFixturesPath('stubs') . '/composer.stub';

        $this->stub = Stub::createFromPath($path);

        $this->assertEmpty($this->stub->getBasePath());
        $this->assertEquals($path, $this->stub->getPath());
        $this->assertEmpty($this->stub->getReplaces());
    }
}
