<?php namespace Arcanedev\Support\Bases;

use Closure;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     RouteRegister
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Registrar */
    protected $router;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  Registrar  $router
     */
    public function map(Registrar $router)
    {
        $this->setRegister($router);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param  Registrar  $router
     *
     * @return self
     */
    public function setRegister(Registrar $router)
    {
        $this->router = $router;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Route registration Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register a new GET route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     */
    public function get($uri, $action)
    {
        $this->router->get($uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     */
    public function post($uri, $action)
    {
        $this->router->post($uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     */
    public function put($uri, $action)
    {
        $this->router->put($uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     */
    public function delete($uri, $action)
    {
        $this->router->delete($uri, $action);
    }

    /**
     * Create a route group with shared attributes.
     *
     * @param  array    $attributes
     * @param  Closure  $callback
     */
    protected function group(array $attributes, Closure $callback)
    {
        $this->router->group($attributes, $callback);
    }
}
