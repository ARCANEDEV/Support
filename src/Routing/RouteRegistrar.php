<?php namespace Arcanedev\Support\Routing;

/**
 * Class     RouteRegistrar
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  as(string $name)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  domain(string $domain)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  middleware(string $middleware)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  name(string $name)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  namespace(string $namespace)
 * @method  \Arcanedev\Support\Routing\RouteRegistrar  prefix(string $prefix)
 * @method  void                                       group(...$mixed)
 *
 * @method  \Illuminate\Routing\Route  get($uri, $action = null)
 * @method  \Illuminate\Routing\Route  post($uri, $action = null)
 * @method  \Illuminate\Routing\Route  put($uri, $action = null)
 * @method  \Illuminate\Routing\Route  patch($uri, $action = null)
 * @method  \Illuminate\Routing\Route  delete($uri, $action = null)
 * @method  \Illuminate\Routing\Route  options($uri, $action = null)
 * @method  \Illuminate\Routing\Route  any($uri, $action = null)
 * @method  \Illuminate\Routing\Route  match($methods, $uri, $action = null)
 *
 * @method  void                       resource($name, $controller, array $options = [])
 * @method  void                       resources(array $resources)
 *
 * @method  void                       pattern($key, $pattern)
 * @method  void                       patterns($patterns)
 *
 * @method  void                       model($key, $class, \Closure $callback = null)
 * @method  void                       bind($key, $binder)
 */
abstract class RouteRegistrar
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register and map routes.
     */
    public static function register()
    {
        (new static)->map();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     */
    abstract public function map();

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param  string  $name
     * @param  array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return app('router')->$name(...$arguments);
    }
}
