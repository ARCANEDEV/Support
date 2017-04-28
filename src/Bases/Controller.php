<?php namespace Arcanedev\Support\Bases;

/**
 * Class     Controller
 *
 * @package  Arcanedev\Support\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @deprecated Use `Arcanedev\Support\Http\Controller` instead.
 */
abstract class Controller extends \Arcanedev\Support\Http\Controller
{
    /* -----------------------------------------------------------------
     |  Check Functions
     | -----------------------------------------------------------------
     */

    /**
     * Check if the Request is an ajax Request.
     *
     * @deprecated
     *
     * @return bool
     */
    protected static function isAjaxRequest()
    {
        return request()->ajax();
    }

    /**
     * Accepts only ajax request.
     *
     * @deprecated Use the `ajax` middleware instead.
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function onlyAjax($message = 'Access denied !', array $headers = [])
    {
        if ( ! self::isAjaxRequest()) {
            self::accessNotAllowed($message, $headers);
        }
    }
}
