<?php namespace Arcanedev\Support\Tests\Bases;

use Arcanedev\Support\Tests\TestCase;

/**
 * Class     ModelTest
 *
 * @package  Arcanedev\Support\Tests\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ModelTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  \Arcanedev\Support\Bases\Model */
    protected $model;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->model = new \Arcanedev\Support\Tests\Stubs\Models\Product;
    }

    public function tearDown()
    {
        unset($this->model);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Database\Eloquent\Model::class,
            \Arcanedev\Support\Bases\Model::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->model);
        }
    }

    /** @test */
    public function it_can_get_table_name_without_prefix()
    {
        $this->assertSame('products', $this->model->getTable());
    }

    /** @test */
    public function it_can_set_and_get_prefix()
    {
        $this->model->setPrefix($prefix = 'shop_');

        $this->assertSame($prefix, $this->model->getPrefix());
        $this->assertSame($prefix . 'products', $this->model->getTable());
    }
}
