<?php namespace Arcanedev\Support\Bases;

use Closure;
use Illuminate\Database\Migrations\Migration as IlluminateMigration;
use Illuminate\Support\Facades\Schema;

/**
 * Class     Migration
 *
 * @package  Arcanedev\Support\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Migration extends IlluminateMigration
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The name of the database connection to use.
     *
     * @var string|null
     */
    protected $connection;

    /**
     * The table name.
     *
     * @var string|null
     */
    protected $table;

    /**
     * The table prefix.
     *
     * @var string|null
     */
    protected $prefix;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the table name.
     *
     * @return string
     */
    public function getTableName()
    {
        $table = $this->table;

        if ($this->isPrefixed()) {
            $table = $this->prefix . $table;
        }

        return $table;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Migrate to database.
     */
    abstract public function up();

    /**
     * Rollback the migration.
     */
    public function down()
    {
        if ( ! $this->hasConnection()) {
            Schema::dropIfExists($this->getTableName());

            return;
        }

        Schema::connection($this->connection)->dropIfExists($this->getTableName());
    }

    /**
     * Create Table Schema.
     *
     * @param  \Closure  $blueprint
     */
    protected function createSchema(Closure $blueprint)
    {
        if ( ! $this->hasConnection()) {
            Schema::create($this->getTableName(), $blueprint);

            return;
        }

        Schema::connection($this->connection)->create($this->getTableName(), $blueprint);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if connection exists.
     *
     * @return bool
     */
    protected function hasConnection()
    {
        return ! (is_null($this->connection) || empty($this->connection));
    }

    /**
     * Check if table has prefix.
     *
     * @return bool
     */
    protected function isPrefixed()
    {
        return ! (is_null($this->prefix) || empty($this->prefix));
    }
}
