<?php namespace Arcanedev\Support\Tests;

use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 * @package Arcanedev\Support\Tests
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
