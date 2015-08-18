<?php namespace Arcanedev\Support\Contracts;

/**
 * Interface Jsonable
 * @package Arcanedev\Support\Contracts
 */
interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0);
}
