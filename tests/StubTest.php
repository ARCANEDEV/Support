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
        parent::tearDown();

        unset($this->stub);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->stub = new Stub(__DIR__ . '/stubs/composer.stub');
        $this->assertInstanceOf('Arcanedev\\Support\\Stub', $this->stub);
        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/composer.stub'),
            $this->stub->render()
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/composer.stub'),
            (string) $this->stub
        );
    }

    /** @test */
    public function it_can_create()
    {
        $this->stub = Stub::create(__DIR__ . '/stubs/composer.stub');

        $this->stub->replaces([
            'VENDOR'            => 'arcanedev',
            'PACKAGE'           => 'package',
            'AUTHOR_NAME'       => 'ARCANEDEV',
            'AUTHOR_EMAIL'      => 'arcanedev.maroc@gmail.com',
            'MODULE_NAMESPACE'  => str_studly('arcanedev'),
            'STUDLY_NAME'       => str_studly('package'),
        ]);

        $this->stub->saveTo(__DIR__ . '/stubs', 'composer.json');
        $this->assertEquals(file_get_contents(__DIR__ . '/stubs/composer.json'), $this->stub->render());
    }
}
