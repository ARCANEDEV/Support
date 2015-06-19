<?php namespace Arcanedev\Support\Tests;

use Arcanedev\Support\Json;

class JsonTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Json */
    private $json;

    /** @var string */
    private $filePath;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->filePath    = __DIR__ . '/fixtures/file-1.json';
        $this->json        = new Json($this->filePath);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->json);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(
            'Arcanedev\\Support\\Json',
            $this->json
        );
        $this->assertInstanceOf(
            'Illuminate\\Filesystem\\Filesystem',
            $this->json->getFilesystem()
        );
        $this->assertEquals($this->convertFixture(), $this->json->toArray());
    }

    /** @test */
    public function it_can_make()
    {
        $this->json = Json::make($this->filePath);
        $this->assertInstanceOf(
            'Arcanedev\\Support\\Json',
            $this->json
        );
        $this->assertInstanceOf(
            'Illuminate\\Filesystem\\Filesystem',
            $this->json->getFilesystem()
        );
        $this->assertEquals($this->convertFixture(), $this->json->toArray());
    }

    /** @test */
    public function it_can_get_an_attribute()
    {
        $fixture = $this->convertFixture();

        $this->assertEquals($fixture['name'], $this->json->get('name'));
        $this->assertEquals($fixture['name'], $this->json->name);

        $this->assertEquals($fixture['description'], $this->json->get('description'));
        $this->assertEquals($fixture['description'], $this->json->description);
    }

    /** @test */
    public function it_can_set_and_get_path()
    {
        $this->assertEquals($this->filePath, $this->json->getPath());

        $this->json->setPath($this->filePath = __DIR__ . '/fixtures/file-2.json');

        $this->assertEquals($this->filePath, $this->json->getPath());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function convertFixture()
    {
        return [
            'name'          => 'arcanedev/support',
            'description'   => 'ARCANEDEV Support Helpers',
            'keywords'      => ['arcanedev', 'support'],
            'license'       => 'MIT',
            'authors'       => [
                [
                    'name'  => 'ARCANEDEV',
                    'email' => 'contact@arcanedev.net',
                ]
            ],
        ];
    }
}
