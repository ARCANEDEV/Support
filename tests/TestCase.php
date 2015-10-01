<?php namespace Arcanedev\Support\Tests;

use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Support\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get fixture path
     *
     * @param  string  $path
     *
     * @return string
     */
    protected function getFixturesPath($path)
    {
        return __DIR__ . '/fixtures/' . $path;
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $this->registerRoutes($app);
    }

    /**
     * Register routes.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    private function registerRoutes($app)
    {
        /** @var Router $router */
        $router = $app['router'];

        $router->middleware('json', 'Arcanedev\\Support\\Middleware\\VerifyJsonRequest');

        $router->get('dummy', [
            'as'    => 'dummy::index',
            'uses'  => 'Arcanedev\\Support\\Tests\\Stubs\\DummyController@index'
        ]);

        $router->get('dummy/{slug}', [
            'as'    => 'dummy::get',
            'uses'  => 'Arcanedev\\Support\\Tests\\Stubs\\DummyController@getOne'
        ]);

        $router->group([
            'as'    => 'middleware::'
        ], function(Router $router) {
            $router->group([
                'prefix' => 'json',
                'as'     => 'json.'
            ], function (Router $router) {
                $router->get('/', [
                    'as'         => 'empty',
                    'middleware' => 'json',
                    function () {
                        return response()->json(['status' => 'success']);
                    }
                ]);

                $router->get('param', [
                    'as'         => 'param',
                    'middleware' => 'json:get',
                    function () {
                        return response()->json(['status' => 'success']);
                    }
                ]);

                $router->post('param', [
                    'as'         => 'param',
                    'middleware' => 'json:post',
                    function () {
                        return response()->json(['status' => 'success']);
                    }
                ]);

                $router->put('param', [
                    'as'         => 'param',
                    'middleware' => 'json:put',
                    function () {
                        return response()->json(['status' => 'success']);
                    }
                ]);

                $router->delete('param', [
                    'as'         => 'param',
                    'middleware' => 'json:delete',
                    function () {
                        return response()->json(['status' => 'success']);
                    }
                ]);

                $router->get('params', [
                    'as'         => 'params',
                    'middleware' => 'json:get',
                    function () {
                        return response()->json(['status' => 'success']);
                    }
                ]);
            });
        });
    }
}
