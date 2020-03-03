<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests\Stubs;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     PagesRoutes
 *
 * @package  Arcanedev\Support\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PagesRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function bindings(): void
    {
        $this->bind('page', function ($page) {
            return str_replace('page-', '', $page);
        });
    }

    public function map(): void
    {
        $this->name('public::')->middleware('bindings')->group(function () {
            $this->get('/', function () {
                return 'Welcome';
            })->name('index'); // public::index

            $this->mapContactFormRoutes();

            $this->get('/pages/{page}', function ($page) {
                return $page;
            })->name('pages.show'); // public::pages.show
        });
    }

    private function mapContactFormRoutes(): void
    {
        $this->prefix('contact')->name('contact.')->group(function () {
            $this->get('/', function () {
                return 'Contact Form';
            })->name('show'); // public::contact.show

            $this->post('/', function () {
                return 'Contact Form Posted';
            })->name('post'); // public::contact.post
        });
    }
}
