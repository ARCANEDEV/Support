<?php namespace Arcanedev\Support\Tests\Stubs;

use Arcanedev\Support\Bases\Controller;

/**
 * Class     DummyController
 *
 * @package  Arcanedev\Support\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DummyController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $template = 'welcome';

    /* ------------------------------------------------------------------------------------------------
     |  Actions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        return 'Dummy';
    }

    public function getOne($slug)
    {
        if ($slug !== 'super') {
            $this->pageNotFound('Super dummy not found !');
        }

        return 'Super dummy';
    }
}
