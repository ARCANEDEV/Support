<?php

use Arcanedev\Support\Arr;

if ( ! function_exists('array_add'))
{
    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    function array_add($array, $key, $value)
    {
        return Arr::add($array, $key, $value);
    }
}

if ( ! function_exists('array_build'))
{
    /**
     * Build a new array using a callback.
     *
     * @param  array     $array
     * @param  \Closure  $callback
     * @return array
     */
    function array_build($array, Closure $callback)
    {
        return Arr::build($array, $callback);
    }
}

if ( ! function_exists('array_divide'))
{
    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array  $array
     * @return array
     */
    function array_divide($array)
    {
        return Arr::divide($array);
    }
}

if ( ! function_exists('array_dot'))
{
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array   $array
     * @param  string  $prepend
     * @return array
     */
    function array_dot($array, $prepend = '')
    {
        return Arr::dot($array, $prepend);
    }
}

if ( ! function_exists('array_except'))
{
    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_except($array, $keys)
    {
        return Arr::except($array, $keys);
    }
}

if ( ! function_exists('array_fetch'))
{
    /**
     * Fetch a flattened array of a nested array element.
     *
     * @param  array   $array
     * @param  string  $key
     * @return array
     */
    function array_fetch($array, $key)
    {
        return Arr::fetch($array, $key);
    }
}

if ( ! function_exists('array_first'))
{
    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param  array     $array
     * @param  \Closure  $callback
     * @param  mixed     $default
     * @return mixed
     */
    function array_first($array, $callback, $default = null)
    {
        return Arr::first($array, $callback, $default);
    }
}

if ( ! function_exists('array_last'))
{
    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param  array     $array
     * @param  \Closure  $callback
     * @param  mixed     $default
     * @return mixed
     */
    function array_last($array, $callback, $default = null)
    {
        return Arr::last($array, $callback, $default);
    }
}

if ( ! function_exists('array_flatten'))
{
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array  $array
     * @return array
     */
    function array_flatten($array)
    {
        return Arr::flatten($array);
    }
}

if ( ! function_exists('array_forget'))
{
    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return void
     */
    function array_forget(&$array, $keys)
    {
        Arr::forget($array, $keys);
    }
}

if ( ! function_exists('array_get'))
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

if ( ! function_exists('array_only'))
{
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_only($array, $keys)
    {
        return Arr::only($array, $keys);
    }
}

if ( ! function_exists('array_pluck'))
{
    /**
     * Pluck an array of values from an array.
     *
     * @param  array   $array
     * @param  string  $value
     * @param  string  $key
     * @return array
     */
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}

if ( ! function_exists('array_pull'))
{
    /**
     * Get a value from the array, and remove it.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_pull(&$array, $key, $default = null)
    {
        return Arr::pull($array, $key, $default);
    }
}

if ( ! function_exists('array_set'))
{
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        return Arr::set($array, $key, $value);
    }
}

if ( ! function_exists('array_sort'))
{
    /**
     * Sort the array using the given Closure.
     *
     * @param  array     $array
     * @param  \Closure  $callback
     * @return array
     */
    function array_sort($array, Closure $callback)
    {
        return Arr::sort($array, $callback);
    }
}

if ( ! function_exists('array_where'))
{
    /**
     * Filter the array using the given Closure.
     *
     * @param  array     $array
     * @param  \Closure  $callback
     * @return array
     */
    function array_where($array, Closure $callback)
    {
        return Arr::where($array, $callback);
    }
}