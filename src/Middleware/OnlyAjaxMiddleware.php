<?php namespace Arcanedev\Support\Middleware;

use Arcanedev\Support\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

/**
 * Class     OnlyAjaxMiddleware
 *
 * @package  Arcanedev\Support\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @deprecated use `arcanedev/laravel-api-helper` package.
 */
class OnlyAjaxMiddleware extends Middleware
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        return response('Method not allowed', 405);
    }
}
