<?php namespace Arcanedev\Support\Bases;

use Illuminate\Routing\Controller as IlluminateController;

/**
 * Class     Controller
 *
 * @package  Arcanedev\Support\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends IlluminateController
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use \Arcanedev\Support\Traits\AbortTrait,
        \Illuminate\Foundation\Auth\Access\AuthorizesRequests,
        \Illuminate\Foundation\Bus\DispatchesJobs,
        \Illuminate\Foundation\Validation\ValidatesRequests;

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

    /**
     * The view data.
     *
     * @var array
     */
    protected $data         = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        $this->setData('page', '');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Illuminate Functions
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
    protected function setupLayout()
    {
        if (is_null($this->template)) {
            abort(500, 'The layout is not set');
        }

        if ( ! $this->checkViewExists($this->template)) {
            abort(500, 'The layout [' . $this->template . '] not found');
        }

        $this->layout = view($this->template);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set view data.
     *
     * @param  string|array  $name
     * @param  mixed         $value
     *
     * @return self
     */
    protected function setData($name, $value = null)
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        }
        elseif (is_string($name)) {
            $this->data[$name]  = $value;
        }

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
        if ( ! $this->checkViewExists($view)) {
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
    protected function checkViewExists($view)
    {
        /** @var \Illuminate\View\Factory $viewFactory */
        $viewFactory = view();

        return $viewFactory->exists($view);
    }

    /**
     * Check if the Request is an ajax Request.
     *
     * @return bool
     */
    protected static function isAjaxRequest()
    {
        return request()->ajax();
    }

    /**
     * Accepts only ajax request.
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function onlyAjax($message = 'Access denied !', array $headers = [])
    {
        if ( ! self::isAjaxRequest()) {
            self::accessNotAllowed($message, $headers);
        }
    }
}
