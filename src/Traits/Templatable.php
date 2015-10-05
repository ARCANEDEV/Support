<?php namespace Arcanedev\Support\Traits;

/**
 * Trait     Templatable
 *
 * @package  Arcanedev\Support\Traits
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  array  $data
 */
trait Templatable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The view template - master, layout (... whatever).
     *
     * @var string
     */
    protected $template     = '_templates.default.master';

    /**
     * The layout view.
     *
     * @var \Illuminate\View\View
     */
    private $layout;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get template.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set template.
     *
     * @param  string  $template
     *
     * @return self
     */
    protected function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Display the view.
     *
     * @param  string  $view
     *
     * @return \Illuminate\View\View
     */
    protected function view($view)
    {
        if ( ! $this->isViewExists($view)) {
            abort(500, 'The view [' . $view . '] not found');
        }

        return $this->layout->with($this->data)->nest('content', $view, $this->data);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if view exists.
     *
     * @param  string  $view
     *
     * @return bool
     */
    protected function isViewExists($view)
    {
        /** @var \Illuminate\View\Factory $viewFactory */
        $viewFactory = view();

        return $viewFactory->exists($view);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $this->setupLayout();

        return parent::callAction($method, $parameters);
    }

    /**
     * Setup the template/layout.
     */
    private function setupLayout()
    {
        if (is_null($this->template)) {
            abort(500, 'The layout is not set');
        }

        if ( ! $this->isViewExists($this->template)) {
            abort(500, 'The layout [' . $this->template . '] not found');
        }

        $this->layout = view($this->template);
    }
}
