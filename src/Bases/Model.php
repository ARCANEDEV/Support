<?php namespace Arcanedev\Support\Bases;

use Arcanedev\Support\Traits\PrefixedModel;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class     Model
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Model extends Eloquent
{
    use PrefixedModel;
}
