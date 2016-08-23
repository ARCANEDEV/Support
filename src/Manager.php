<?php namespace Arcanedev\Support;

use Illuminate\Support\Manager as IlluminateManager;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Class     Manager
 *
 * @package  Arcanedev\Support
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Manager extends IlluminateManager
{
    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     *
     * @return mixed
     */
    protected function createDriver($driver)
    {
        $method = 'create'.Str::studly($driver).'Driver';

        // We'll check to see if a creator method exists for the given driver. If not we
        // will check for a custom driver creator, which allows developers to create
        // drivers using their own customized driver creator Closure to create it.
        if (isset($this->customCreators[$driver]))
            return $this->callCustomCreator($driver);
        elseif (method_exists($this, $method))
            return $this->$method();

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }
}
