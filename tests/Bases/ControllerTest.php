<?php namespace Arcanedev\Support\Tests\Bases;

use Arcanedev\Support\Tests\TestCase;

/**
 * Class     ControllerTest
 *
 * @package  Arcanedev\Support\Tests\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ControllerTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_do_dummy_stuff()
    {
        $response = $this->route('GET', 'dummy::index');

        $this->assertResponseOk();
        $this->assertEquals('Dummy', $response->getContent());

        $response = $this->route('GET', 'dummy::get', ['super']);

        $this->assertResponseOk();
        $this->assertEquals('Super dummy', $response->getContent());
    }

    /**
     * @test
     *
     * @expectedException        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Super dummy not found !
     */
    public function it_can_throw_four_o_four_exception()
    {
        $this->route('GET', 'dummy::get', ['not-super']);
    }
}
