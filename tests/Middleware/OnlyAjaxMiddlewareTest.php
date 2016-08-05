<?php namespace Arcanedev\Support\Tests\Middleware;

use Arcanedev\Support\Tests\TestCase;

/**
 * Class     OnlyAjaxMiddlewareTest
 *
 * @package  Arcanedev\Support\Tests\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class OnlyAjaxMiddlewareTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_access_with_get_method()
    {
        $response = $this->route('GET', 'middleware::ajax.get', [], [], [], [], [
            'CONTENT_TYPE'          => 'application/json',
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);

        $this->assertValidJsonResponse($response);
    }

    /** @test */
    public function it_must_block_non_ajax_call()
    {
        $response = $this->route('GET', 'middleware::ajax.get');

        $this->assertFalse($response->isOk());
        $this->assertResponseStatus(405);
        $this->assertEquals('Method not allowed', $response->content());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Assert valid JSON Response.
     *
     * @param \Illuminate\Http\Response|\Illuminate\Http\JsonResponse $response
     */
    protected function assertValidJsonResponse($response)
    {
        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
        $this->assertResponseOk();
        $this->assertJson($response->getContent());

        $json = $response->getData(true);

        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('success', $json['status']);
    }
}
