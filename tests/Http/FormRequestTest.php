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
        $this->call('POST', 'form-request');

        $this->assertResponseStatus(302);

        $this->call('POST', 'form-request', [
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]);

        $this->assertResponseOk();
        $this->assertSame(json_encode([
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]), $this->response->content());
    }

    /** @test */
    public function it_can_sanitize()
    {
        $this->call('POST', 'form-request', [
            'name'  => 'Arcanedev',
            'email' => ' ARCANEDEV@example.COM ',
        ]);

        $this->assertResponseOk();
        $this->assertSame(json_encode([
            'name'  => 'ARCANEDEV',
            'email' => 'arcanedev@example.com',
        ]), $this->response->content());
    }
}
