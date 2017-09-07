<?php namespace Arcanedev\Support\Tests\Http;

use Arcanedev\Support\Http\FormRequest;
use Arcanedev\Support\Tests\TestCase;

/**
 * Class     FormRequestTest
 *
 * @package  Arcanedev\Support\Tests\Http
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FormRequestTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_check_validation()
    {
        $response = $this->post('form-request');
        $response->assertStatus(302);

        $response = $this->post('form-request', [
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]);
    }

    /** @test */
    public function it_can_sanitize()
    {
        $response = $this->post('form-request', [
            'name'  => 'Arcanedev',
            'email' => ' ARCANEDEV@example.COM ',
        ]);

        $response->assertSuccessful();
        $response->assertJson([
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]);
    }
}
