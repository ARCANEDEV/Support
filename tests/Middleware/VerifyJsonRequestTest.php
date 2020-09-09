<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests\Middleware;

use Arcanedev\Support\Middleware\VerifyJsonRequest;
use Arcanedev\Support\Tests\TestCase;
use Illuminate\Routing\Router;

/**
 * Class     VerifyJsonRequestTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class VerifyJsonRequestTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupRoutes($this->app['router']);
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_get_json_response(): void
    {
        $this->json('GET', route('middleware::json.empty'))
             ->assertSuccessful()
             ->assertJson(['status' => 'success']);
    }

    /** @test */
    public function it_can_pass_json_middleware(): void
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
            $this->json($method, route('middleware::json.param'))
                 ->assertSuccessful()
                 ->assertJson(['status' => 'success']);
        }
    }

    /** @test */
    public function it_cannot_pass_json_middleware(): void
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
            $this->call($method, route('middleware::json.param'))
                 ->assertStatus(400)
                 ->assertJson([
                     'status'  => 'error',
                     'code'    => 400,
                     'message' => 'Request must be JSON',
                 ]);
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Setup the routes.
     *
     * @param  \Illuminate\Routing\Router  $router
     */
    private function setupRoutes(Router $router): void
    {
        $router->aliasMiddleware('json', VerifyJsonRequest::class);

        $router->prefix('json')->name('middleware::json.')->group(function(Router $router) {
            $router->get('/', function () {
                return response()->json(['status' => 'success']);
            })->name('empty')->middleware(['json']);

            foreach (['get', 'post', 'put', 'patch', 'delete'] as $method) {
                $router->{$method}('param', function () {
                    return response()->json(['status' => 'success']);
                })->name('param')->middleware(["json:{$method}"]);
            }
        });
    }
}
