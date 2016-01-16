<?php namespace Arcanedev\Support\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanedev\Support\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define policies.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @param  string                                  $class
     * @param  array                                   $policies
     */
    protected function defineMany($gate, $class, array $policies)
    {
        foreach ($policies as $method => $ability) {
            $gate->define($ability, "$class@$method");
        }
    }
}
