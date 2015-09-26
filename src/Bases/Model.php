<?php namespace Arcanedev\Support\Bases;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class     Model
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Model extends Eloquent
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The table prefix.
     *
     * @var string
     */
    protected $prefix       = '';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct($attributes = [])
    {
        if ($this->isPrefixed()) {
            $this->table = $this->prefix . $this->table;
        }

        parent::__construct($attributes);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if table is prefixed.
     *
     * @return bool
     */
    protected function isPrefixed()
    {
        return ! empty($this->prefix);
    }
}
