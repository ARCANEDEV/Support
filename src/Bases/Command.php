<?php namespace Arcanedev\Support\Bases;

use Illuminate\Console\Command as IlluminateCommand;
use Symfony\Component\Console\Helper\TableSeparator;

/**
 * Class     Command
 *
 * @package  Arcanedev\Support\Laravel\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Command extends IlluminateCommand
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Execute the console command.
     */
    abstract public function handle();

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get table separator
     *
     * @return TableSeparator
     */
    protected function tableSeparator()
    {
        return new TableSeparator;
    }

    /**
     * Display header
     *
     * @param  string  $header
     */
    protected function header($header)
    {
        $line   = '+' . str_repeat('-', strlen($header) + 4) . '+';
        $this->info($line);
        $this->info("|  $header  |");
        $this->info($line);
    }
}
