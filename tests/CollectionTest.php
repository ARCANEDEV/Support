<?php namespace Arcanedev\Support\Tests;
use Arcanedev\Support\Collection;

/**
 * Class     CollectionTest
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CollectionTest extends TestCase
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
    public function it_can_reset()
    {
        $items  = [
            'item-1',
            'item-2',
        ];
        $collect = new Collection($items);

        $this->assertCount(count($items), $collect);

        $collect->reset();

        $this->assertCount(0, $collect);
    }
}
