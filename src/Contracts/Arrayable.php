<?php namespace Arcanedev\Support\Contracts;

/**
 * Interface Arrayable
 * @package Arcanedev\Support\Contracts
 */
interface Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();
}
