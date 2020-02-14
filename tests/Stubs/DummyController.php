<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests\Stubs;

use Arcanedev\Support\Http\Controller;

/**
 * Class     DummyController
 *
 * @package  Arcanedev\Support\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DummyController extends Controller
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    protected $template = 'welcome';

    /* -----------------------------------------------------------------
     |  Actions
     | -----------------------------------------------------------------
     */

    public function index()
    {
        return 'Dummy';
    }

    public function show($slug)
    {
        abort_unless($slug === 'super', 404, 'Super dummy not found !');

        return 'Super dummy';
    }
}
