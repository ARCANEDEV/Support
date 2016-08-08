<?php namespace Arcanedev\Support;

use Illuminate\Support\Collection as IlluminateCollection;

/**
 * Class     Collection
 *
 * @package  Arcanedev\Support
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Collection extends IlluminateCollection
{
    /* ------------------------------------------------------------------------------------------------
     |  Illuminate Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Filter items by the given key value pair.
     *
     * @param  string  $key
     * @param  array   $values
     * @param  bool    $strict
     *
     * @return static
     */
    public function whereIn($key, array $values, $strict = true)
    {
        return $this->filter(function ($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    }

    /* ------------------------------------------------------------------------------------------------
     |  Custom Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Reset the collection.
     *
     * @return self
     */
    public function reset()
    {
        $this->items = [];

        return $this;
    }
}
