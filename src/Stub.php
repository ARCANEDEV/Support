<?php namespace Arcanedev\Support;

/**
 * Class Stub
 * @package Arcanedev\Support
 */
class Stub
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The stub path.
     *
     * @var string
     */
    protected $path;

    /**
     * The base path of stub file.
     *
     * @var null|string
     */
    protected static $basePath = null;

    /**
     * The replacements array.
     *
     * @var array
     */
    protected $replaces = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The constructor.
     *
     * @param string $path
     * @param array  $replaces
     */
    public function __construct($path, array $replaces = [])
    {
        $this->path     = $path;
        $this->replaces = $replaces;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get stub path.
     *
     * @return string
     */
    public function getPath()
    {
        return static::$basePath . $this->path;
    }

    /**
     * Set stub path.
     *
     * @param  string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get base path.
     *
     * @return string|null
     */
    public static function getBasePath()
    {
        return static::$basePath;
    }

    /**
     * Set base path.
     *
     * @param string $path
     */
    public static function setBasePath($path)
    {
        static::$basePath = $path;
    }

    /**
     * Get replacements.
     *
     * @return array
     */
    public function getReplaces()
    {
        return $this->replaces;
    }

    /**
     * Set replacements array.
     *
     * @param  array $replaces
     *
     * @return $this
     */
    public function replace(array $replaces = [])
    {
        $this->replaces = $replaces;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create new self instance.
     *
     * @param  string $path
     * @param  array  $replaces
     *
     * @return self
     */
    public static function create($path, array $replaces = [])
    {
        return new static($path, $replaces);
    }

    /**
     * Create new self instance from full path.
     *
     * @param  string $path
     * @param  array  $replaces
     *
     * @return self
     */
    public static function createFromPath($path, array $replaces = [])
    {
        $stub = static::create($path, $replaces);
        $stub->setBasePath('');

        return $stub;
    }

    /**
     * Get stub contents.
     *
     * @return string
     */
    public function render()
    {
        return $this->getContents();
    }

    /**
     * Get stub contents.
     *
     * @return mixed|string
     */
    public function getContents()
    {
        $contents = file_get_contents($this->getPath());

        foreach ($this->replaces as $search => $replace) {
            $contents = str_replace('$' . strtoupper($search) . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Save stub to specific path.
     *
     * @param  string $path
     * @param  string $filename
     *
     * @return bool
     */
    public function saveTo($path, $filename)
    {
        return file_put_contents($path . '/' . $filename, $this->getContents());
    }

    /**
     * Handle magic method __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
