<?php

declare(strict_types=1);

namespace Arcanedev\Support\Providers\Concerns;

/**
 * Trait     HasViews
 *
 * @package  Arcanedev\Support\Providers\Concerns
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait HasViews
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the base views path.
     *
     * @return string
     */
    protected function getViewsPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views';
    }

    /**
     * Get the destination views path.
     *
     * @return string
     */
    protected function getViewsDestinationPath()
    {
        return $this->app['config']['view.paths'][0].DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.$this->package;
    }

    /**
     * Publish and load the views if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishViews($load = true)
    {
        $this->publishes([
            $this->getViewsPath() => $this->getViewsDestinationPath()
        ], 'views');

        if ($load)
            $this->loadViews();
    }

    /**
     * Load the views files.
     */
    protected function loadViews()
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->package);
    }
}
