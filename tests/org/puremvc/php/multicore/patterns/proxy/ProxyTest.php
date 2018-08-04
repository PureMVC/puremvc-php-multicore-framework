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

use puremvc\php\multicore\interfaces\IProxy;
use puremvc\php\multicore\patterns\proxy\Proxy;



/**
 * Test the PureMVC Proxy class.
 *
 * @see IProxy
        org\puremvc\php\interfaces\IProxy.php
 * @see Proxy
        org\puremvc\php\patterns\proxy\Proxy.php
 * @package org.puremvc.php.multicore.unittest
 */
class ProxyTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var Proxy
     */
    private $Proxy;

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
     * Tests getting the name using Proxy class accessor method. Setting can only be done in constructor.
     */
    public function testNameAccessor()
    {
        // Create a new Proxy and use accessors to set the proxy name
        $proxy = new Proxy( 'TestProxy' );

        // test assertions
        $this->assertTrue( $proxy->getProxyName() == 'TestProxy', "Expecting proxy.getProxyName() == 'TestProxy'" );
    }

    /**
     * Tests setting and getting the data using Proxy class accessor methods.
     */
    public function testDataAccessors()
    {
        // Create a new Proxy and use accessors to set the data
        $proxy = new Proxy( 'colors' );
        $proxy->setData( array('red', 'green', 'blue') );
        $data = $proxy->getData();

        // test assertions
        $this->assertTrue( sizeof($data) == 3, "Expecting data.length == 3" );
        $this->assertTrue( $data[0]  == 'red', "Expecting data[0] == 'red'" );
        $this->assertTrue( $data[1]  == 'green', "Expecting data[1] == 'green'" );
        $this->assertTrue( $data[2]  == 'blue', "Expecting data[2] == 'blue'" );
    }

    /**
     * Tests setting the name and body using the Notification class Constructor.
     */
    public function testConstructor()
    {
        // Create a new Proxy using the Constructor to set the name and data
        $proxy = new Proxy( 'colors', array('red', 'green', 'blue') );
        $data = $proxy->getData();

        // test assertions
        $this->assertNotNull( $proxy, "Expecting proxy not null" );
        $this->assertTrue( $proxy->getProxyName() == 'colors', "Expecting proxy.getProxyName() == 'colors'" );
        $this->assertTrue( sizeof($data) == 3, "Expecting data.length == 3" );
        $this->assertTrue( $data[0]  == 'red', "Expecting data[0] == 'red'" );
        $this->assertTrue( $data[1]  == 'green', "Expecting data[1] == 'green'" );
        $this->assertTrue( $data[2]  == 'blue', "Expecting data[2] == 'blue'" );
    }

}

