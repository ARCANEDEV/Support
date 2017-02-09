<?php namespace Arcanedev\Support\Providers;

use Arcanedev\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class     ViewComposerServiceProvider
 *
 * @package  Arcanedev\Support\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerClasses = [
        // 'view-name' => 'class'
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Boot the view composer service provider.
     */
    public function boot()
    {
        $this->registerComposerClasses();
    }

    /**
     * Register the view composer classes.
     */
    protected function registerComposerClasses()
    {
        foreach ($this->composerClasses as $view => $class) {
            $this->composer($view, $class);
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the view factory instance.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    protected function view()
    {
        return $this->app->make(ViewFactory::class);
    }

    /**
     * Register a view composer event.
     *
     * @param  array|string     $views
     * @param  \Closure|string  $callback
     *
     * @return array
     */
    public function composer($views, $callback)
    {
        return $this->view()->composer($views, $callback);
    }
}
