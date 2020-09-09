<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests\Http;

use Arcanedev\Support\Tests\Stubs\FormRequestController;
use Arcanedev\Support\Tests\TestCase;
use Illuminate\Routing\Router;

/**
 * Class     FormRequestTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FormRequestTest extends TestCase
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
    public function it_can_check_validation(): void
    {
        $this->post('form-request')
             ->assertStatus(302)
             ->assertRedirect('/');

        $response = $this->post('form-request', [
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'name'  => 'ARCANEDEV',
                'email' => 'arcanedev@example.com',
            ]);
    }

    /** @test */
    public function it_can_sanitize(): void
    {
        $response = $this->post('form-request', [
            'name'  => 'Arcanedev',
            'email' => ' ARCANEDEV@example.COM ',
        ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'name'  => 'ARCANEDEV',
                'email' => 'arcanedev@example.com',
            ]);
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
        $router->post('form-request', [FormRequestController::class, 'form'])
               ->name('form-request');
    }
}
