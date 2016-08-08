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
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_use_where_in()
    {
        $c = new Collection([['v' => 1], ['v' => 2], ['v' => 3], ['v' => '3'], ['v' => 4]]);

        $this->assertEquals([['v' => 1], ['v' => 3]], $c->whereIn('v', [1, 3])->values()->all());
    }

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
