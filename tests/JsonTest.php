<?php namespace Arcanedev\Support\Tests;

use Arcanedev\Support\Json;

/**
 * Class     JsonTest
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class JsonTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Json */
    private $json;

    /** @var string */
    private $fixturePath;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->fixturePath = $this->getFixturePath('file-1.json');
        $this->json     = new Json($this->fixturePath);
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
        $this->assertEquals(
            $this->convertFixture($this->fixturePath),
            $this->json->toArray()
        );
    }

    /** @test */
    public function it_can_make()
    {
        $this->json = Json::make($this->fixturePath);

        $this->assertInstanceOf(
            'Arcanedev\\Support\\Json',
            $this->json
        );
        $this->assertEquals(
            $this->getFixtureContent($this->fixturePath),
            $this->json->getContents()
        );
        $this->assertEquals(
            $this->getFixtureContent($this->fixturePath),
            (string) $this->json
        );
        $this->assertEquals(
            $this->convertFixture($this->fixturePath),
            $this->json->toArray()
        );
    }

    /** @test */
    public function it_can_get_and_set_filesystem()
    {
        $this->assertInstanceOf(
            'Illuminate\\Filesystem\\Filesystem',
            $this->json->getFilesystem()
        );

        $mock       = 'Illuminate\\Filesystem\\Filesystem';
        $filesystem = $this->prophesize($mock);
        $this->json->setFilesystem($filesystem->reveal());

        $this->assertInstanceOf($mock, $this->json->getFilesystem());
    }

    /** @test */
    public function it_can_get_and_set_an_attribute()
    {
        $fixture = $this->convertFixture($this->fixturePath);

        $this->assertEquals($fixture['name'], $this->json->get('name'));
        $this->assertEquals($fixture['name'], $this->json->name);
        $this->assertEquals($fixture['name'], $this->json->name());

        $this->assertEquals($fixture['description'], $this->json->get('description'));
        $this->assertEquals($fixture['description'], $this->json->description);
        $this->assertEquals($fixture['description'], $this->json->description());

        $this->assertNull($this->json->get('url', null));
        $this->assertNull($this->json->url);
        $this->assertNull($this->json->url());

        $url = 'https://www.github.com';
        $this->json->set('url', $url);

        $this->assertEquals($url, $this->json->get('url'));
        $this->assertEquals($url, $this->json->url);
        $this->assertEquals($url, $this->json->url());
    }

    /** @test */
    public function it_can_set_and_get_path()
    {
        $this->assertEquals($this->fixturePath, $this->json->getPath());

        $this->fixturePath = $this->getFixturePath('file-2.json');
        $this->json->setPath($this->fixturePath);

        $this->assertEquals($this->fixturePath, $this->json->getPath());
    }

    /** @test */
    public function it_can_save()
    {
        $path = $this->getFixturePath('saved.json');

        $this->assertNotFalse($this->json->setPath($path)->save());

        $this->assertEquals(
            $this->getFixtureContent($path),
            $this->json->getContents()
        );

        unlink($path);
    }

    /** @test */
    public function it_can_update()
    {
        $path = $this->getFixturePath('saved.json');

        $this->assertEquals(5, count($this->json->getAttributes()));
        $this->assertNotFalse($this->json->setPath($path)->save());
        $this->assertEquals(
            $this->getFixtureContent($path),
            $this->json->getContents()
        );

        $this->json->update(['url' => 'https://www.github.com']);
        $this->assertEquals(6, count($this->json->getAttributes()));

        unlink($path);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get fixture path
     *
     * @param  string $filename
     *
     * @return string
     */
    private function getFixturePath($filename)
    {
        return __DIR__ . "/fixtures/$filename";
    }

    /**
     * @param  string $path
     *
     * @return string
     */
    private function getFixtureContent($path)
    {
        return file_get_contents($path);
    }

    /**
     * Convert fixture file to array
     *
     * @return array
     */
    private function convertFixture($path)
    {
        return json_decode($this->getFixtureContent($path), JSON_PRETTY_PRINT);
    }
}
