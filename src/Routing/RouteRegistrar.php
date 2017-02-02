<?php namespace Arcanedev\Support\Routing;

use Closure;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar as IlluminateRouteRegistrar;

/**
 * Class     RouteRegistrar
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  prefix(string $prefix)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  name(string $name)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  as(string $name)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  namespace(string $namespace)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  domain(string $domain)
 */
abstract class RouteRegistrar extends IlluminateRouteRegistrar
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register and map routes.
     *
     * @param  \Illuminate\Routing\Router  $router
     */
    public static function register(Router $router)
    {
        (new static($router))->map();
    }

    /**
     * Map routes.
     */
    abstract public function map();

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set a global where pattern on all routes.
     *
     * @param  string  $key
     * @param  string  $pattern
     */
    public function pattern($key, $pattern)
    {
        $this->router->pattern($key, $pattern);
    }

    /**
     * Set a group of global where patterns on all routes.
     *
     * @param  array  $patterns
     */
    public function patterns($patterns)
    {
        $this->router->patterns($patterns);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register a new GET route with the router.
     *
     * @param  string                      $uri
     * @param  \Closure|array|string|null  $action
     *
     * @return \Illuminate\Routing\Route
     */
    protected function get($uri, $action = null)
    {
        return $this->router->get($uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string                      $uri
     * @param  \Closure|array|string|null  $action
     *
     * @return \Illuminate\Routing\Route
     */
    protected function post($uri, $action = null)
    {
        return $this->router->post($uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string|null  $action
     * @return \Illuminate\Routing\Route
     */
    protected function put($uri, $action = null)
    {
        return $this->router->put($uri, $action);
    }

    /**
     * Register a new PATCH route with the router.
     *
     * @param  string                      $uri
     * @param  \Closure|array|string|null  $action
     *
     * @return \Illuminate\Routing\Route
     */
    protected function patch($uri, $action = null)
    {
        return $this->router->patch($uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string                      $uri
     * @param  \Closure|array|string|null  $action
     *
     * @return \Illuminate\Routing\Route
     */
    protected function delete($uri, $action = null)
    {
        return $this->router->delete($uri, $action);
    }

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string                      $uri
     * @param  \Closure|array|string|null  $action
     *
     * @return \Illuminate\Routing\Route
     */
    protected function options($uri, $action = null)
    {
        return $this->router->options($uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param  string                      $uri
     * @param  \Closure|array|string|null  $action
     *
     * @return \Illuminate\Routing\Route
     */
    protected function any($uri, $action = null)
    {
        return $this->router->any($uri, $action);
    }

    /**
     * Add a new route parameter binder.
     *
     * @param  string           $key
     * @param  string|callable  $binder
     */
    protected function bind($key, $binder)
    {
        $this->router->bind($key, $binder);
    }

    /**
     * Register a model binder for a wildcard.
     *
     * @param  string         $key
     * @param  string         $class
     * @param  \Closure|null  $callback
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function model($key, $class, Closure $callback = null)
    {
        $this->router->model($key, $class, $callback);
    }

    /**
     * Clear the attributes.
     *
     * @return self
     */
    public function clear()
    {
        $this->attributes = [];

        return $this;
    }
}
