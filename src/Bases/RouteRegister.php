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
    /**
     * The router instance.
     *
     * @var Registrar
     */
    protected $router;

    /**
     * Base route prefix.
     *
     * @var string
     */
    private $prefix    = '';

    /**
     * Route name.
     *
     * @var string
     */
    private $routeName = '';

    /**
     * Route middlewares.
     *
     * @var array|string
     */
    private $middlewares = null;

    /**
     * Route namespace.
     *
     * @var string
     */
    private $namespace = '';

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

    /**
     * Set prefix.
     *
     * @param  string  $prefix
     *
     * @return self
     */
    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }
    /**
     * Add prefix.
     *
     * @param  string  $prefix
     *
     * @return self
     */
    protected function addPrefix($prefix)
    {
        if ( ! empty($this->prefix)) {
            $prefix = $this->prefix . '/' . $prefix;
        }

        return $this->setPrefix($prefix);
    }

    /**
     * Set route namespace.
     *
     * @param  string  $namespace
     *
     * @return self
     */
    protected function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Set route name.
     *
     * @param  string  $routeName
     *
     * @return self
     */
    protected function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Set route middlewares.
     *
     * @param  array|string  $middleware
     *
     * @return self
     */
    protected function setMiddlewares($middleware)
    {
        $this->middlewares = $middleware;

        return $this;
    }

    /**
     * Get route attributes.
     *
     * @param  array  $merge
     *
     * @return array
     */
    protected function getAttributes(array $merge = [])
    {
        $attributes = [
            'prefix'     => $this->prefix,
            'as'         => $this->routeName,
            'middleware' => $this->middlewares,
            'namespace'  => $this->namespace,
        ];

        return array_merge($attributes, $merge);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Load attributes from config file.
     *
     * @param  string  $key
     * @param  array   $default
     */
    protected function loadAttributes($key, array $default = [])
    {
        $attributes = config($key, $default);

        if (isset($attributes['prefix'])) {
            $this->addPrefix($attributes['prefix']);
        }

        if (isset($attributes['namespace'])) {
            $this->setNamespace($attributes['namespace']);
        }

        if (isset($attributes['as'])) {
            $this->setRouteName($attributes['as']);
        }

        if (isset($attributes['middleware'])) {
            $this->setMiddlewares($attributes['middleware']);
        }
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

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array   $options
     */
    protected function resource($name, $controller, array $options = [])
    {
        $this->router->resource($name, $controller, $options);
    }
}
