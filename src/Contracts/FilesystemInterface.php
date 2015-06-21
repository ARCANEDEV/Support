<?php namespace Arcanedev\Support\Contracts;

/**
 * Interface FilesystemInterface
 * @package Arcanedev\Support\Contracts
 */
interface FilesystemInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return string
     */
    public function get($path);

    /**
     * Write the contents of a file.
     *
     * @param  string  $path
     * @param  string  $contents
     * @param  bool    $lock
     *
     * @return int
     */
    public function put($path, $contents, $lock = false);
}
