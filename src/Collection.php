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
     |  Main Functions
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
