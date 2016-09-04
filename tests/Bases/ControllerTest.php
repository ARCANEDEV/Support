<?php namespace Arcanedev\Support\Tests\Bases;

use Arcanedev\Support\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    /** @test */
    public function it_can_throw_four_o_four_exception()
    {
        try {
            $response   = $this->route('GET', 'dummy::get', ['not-super']);
            $statusCode = $response->getStatusCode();
            $message    = $response->exception->getMessage();

            $this->assertInstanceOf(
                NotFoundHttpException::class,
                $response->exception
            );
        }
        catch(NotFoundHttpException $e) {
            $statusCode = $e->getStatusCode();
            $message    = $e->getMessage();
        }

        $this->assertSame(404, $statusCode);
        $this->assertSame('Super dummy not found !', $message);
    }
}
