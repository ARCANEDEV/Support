<?php

use Illuminate\Support\Str;

if ( ! function_exists('str_studly')) {
    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     *
     * @return string
     */
    function str_studly($value)
    {
        return Str::studly($value);
    }
}
