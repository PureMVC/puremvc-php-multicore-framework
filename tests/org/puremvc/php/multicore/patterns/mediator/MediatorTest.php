<?php
/**
 * PureMVC PHP Multicore Unit Tests
 *
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 *
 * Created on Jully 24, 2009
 *
 * @version 1.1
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 * @author Michael Beck (https://github.com/mambax7/)
 * @copyright PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * @license http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported License
 * @package org.puremvc.php.multicore.unittest
 */
/**
 *
 */
use puremvc\php\multicore\core\View;
use puremvc\php\multicore\patterns\mediator\Mediator;

/**
 * Test the PureMVC Mediator class.
 *
 * @see IMediator
        org\puremvc\php\multicore\interfaces\IMediator.php
 * @see Mediator
        org\puremvc\php\multicore\patterns\mediator\Mediator.php
 * @package org.puremvc.php.multicore.unittest
 */
class MediatorTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var Mediator
     */
    private $Mediator;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }


    /**
     * Tests getting the name using Mediator class accessor method.
     */
    public function testNameAccessor()
    {
        // Create a new Mediator and use accessors to set the mediator name
        $mediator = new Mediator( '' );

        // test assertions
        $this->assertTrue( $mediator->getMediatorName() == Mediator::NAME, "Expecting mediator->getMediatorName() == Mediator::NAME" );
    }

    /**
     * Tests getting the name using Mediator class accessor method.
     */
    public function testViewAccessor()
    {
        // Create a view object
        $view = View::getInstance('testView');

        // Create a new Mediator and use accessors to set the mediator name
        $mediator = new Mediator( Mediator::NAME, $view );

        // test assertions
        $this->assertNotNull( $mediator->getViewComponent(), "Expecting mediator.getViewComponent() not null" );
    }
}

