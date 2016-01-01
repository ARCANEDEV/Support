<?php namespace Arcanedev\Support\Tests\Middleware;

use Arcanedev\Support\Tests\TestCase;

/**
 * Class     VerifyJsonRequestTest
 *
 * @package  Arcanedev\Support\Tests\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class VerifyJsonRequestTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_get_json_response()
    {
        $response = $this->route('GET', 'middleware::json.empty', [], [], [], [], [
            'CONTENT_TYPE' => 'application/json'
        ]);

        $this->assertValidJsonResponse($response);
    }

    /** @test */
    public function it_can_pass_json_middleware()
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE'];

        foreach ($methods as $method) {
            /** @var \Illuminate\Http\JsonResponse $response */
            $response = $this->route($method, 'middleware::json.param', [], [], [], [], [
                'CONTENT_TYPE' => 'application/json'
            ]);

            $this->assertValidJsonResponse($response);
        }
    }

    /** @test */
    public function it_cannot_pass_json_middleware()
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE'];

        foreach ($methods as $method) {
            /** @var \Illuminate\Http\JsonResponse $response */
            $response = $this->route($method, 'middleware::json.param');

            $this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
            $this->assertEquals(400, $response->getStatusCode());
            $this->assertEquals('Request must be json', $response->getData());
        }
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
    private function assertValidJsonResponse($response)
    {
        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
        $this->assertResponseOk();
        $this->assertJson($response->getContent());

        $json = $response->getData(true);

        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('success', $json['status']);
    }
}
