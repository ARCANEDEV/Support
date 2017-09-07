<?php namespace Arcanedev\Support\Tests\Http;

use Arcanedev\Support\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class     ControllerTest
 *
 * @package  Arcanedev\Support\Tests\Http
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
        $response = $this->get(route('dummy::index'));
        $response->assertSuccessful();

        $this->assertEquals('Dummy', $response->getContent());

        $response = $this->get(route('dummy::get', ['super']));

        $response->assertSuccessful();
        $this->assertEquals('Super dummy', $response->getContent());
    }

    /** @test */
    public function it_can_throw_four_o_four_exception()
    {
        $response   = $this->get(route('dummy::get', ['not-super']));

        $response->assertStatus(404);
        $this->assertInstanceOf(NotFoundHttpException::class, $response->exception);
        $this->assertSame('Super dummy not found !', $response->exception->getMessage());
    }
}
