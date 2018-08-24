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

use puremvc\php\multicore\interfaces\IModel;
use puremvc\php\multicore\core\Model;
use puremvc\php\multicore\patterns\proxy\Proxy;




require_once 'ModelTestProxy.php';

/**
 * Test the PureMVC Model class.
 * @see ModelTestProxy
   org\puremvc\php\multicore\core\ModelTestProxy.php
 * @package org.puremvc.php.multicore.unittest
 */
class ModelTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var Model
     */
    private $model;

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
     * Tests the Model Multiton Factory Method
     */
    public function testGetInstance()
    {
        // Test Factory Method
        $model = Model::getInstance('ModelTestKey1');

        // test assertion - Model::getInstance() non-null
        $this->assertNotNull( $model, "Expecting instance not null" );
        $this->assertTrue( $model instanceof IModel, "Expecting instance implements IModel" );

        $model2 = Model::getInstance('ModelTestKey1');
        $this->assertTrue( $model === $model2, "Expecting instances to be the same object" );

    }

    /**
     * Tests the proxy registration and retrieval methods.
     *
     * Tests <b>registerProxy</b> and <b>retrieveProxy</b> in the same test.
     * These methods cannot currently be tested separately
     * in any meaningful way other than to show that the
     * methods do not throw exception when called.
     */
    public function testRegisterAndRetrieveProxy()
    {
        // register a proxy and retrieve it.
        $model = Model::getInstance('ModelTestKey2');
        $model->registerProxy( new Proxy('colors', array('red', 'green', 'blue')) );
        $proxy = $model->retrieveProxy( 'colors' );
        $data = $proxy->getData();

        // test assertions
         $this->assertNotNull( $data, "Expecting data not null" );
         $this->assertTrue( is_array($data), "Expecting data type is Array" );
         $this->assertTrue( count($data) == 3, "Expecting data.length == 3" );
         $this->assertTrue( $data[0]  == 'red', "Expecting data[0] == 'red'" );
         $this->assertTrue( $data[1]  == 'green', "Expecting data[1] == 'green'" );
         $this->assertTrue( $data[2]  == 'blue', "Expecting data[2] == 'blue'" );
    }

    /**
     * Tests the proxy removal method.
     */
    public function testRegisterAndRemoveProxy()
    {
        // register a proxy, remove it, then try to retrieve it
        $model = Model::getInstance('ModelTestKey3');
        $proxy = new Proxy( 'sizes', array('7', '13', '21') );
        $model->registerProxy( $proxy );

        // remove the proxy
        $removedProxy = $model->removeProxy( 'sizes' );

        // assert that we removed the appropriate proxy
        $this->assertTrue( $removedProxy->getProxyName() == 'sizes',
                                "Expecting removedProxy.getProxyName() == 'sizes'" );

        // ensure that the proxy is no longer retrievable from the $model
        $proxy = $model->retrieveProxy( 'sizes' );

        // test assertions
        $this->assertNull( $proxy, "Expecting proxy is null" );
    }

    /**
     * Tests the hasProxy Method
     */
    public function testHasProxy()
    {
        // register a proxy
        $model = Model::getInstance('ModelTestKey4');
        $proxy = new Proxy( 'aces', array('clubs', 'spades', 'hearts', 'diamonds'));
        $model->registerProxy( $proxy );

        // assert that the model.hasProxy method returns true
        // for that proxy name
        $this->assertTrue( $model->hasProxy('aces') == true,
                                "Expecting model.hasProxy('aces') == true" );

        // remove the proxy
        $model->removeProxy( 'aces' );

        // assert that the model.hasProxy method returns false
        // for that proxy name
        $this->assertTrue( $model->hasProxy('aces') == false,
                                "Expecting model.hasProxy('aces') == false" );
    }

    /**
     * Tests that the Model calls the onRegister and onRemove methods.
     */
    public function testOnRegisterAndOnRemove()
    {
        // Get the Singleton View instance
        $model = Model::getInstance('ModelTestKey5');

        // Create and register the test mediator
        $proxy = new ModelTestProxy();
        $model->registerProxy( $proxy );

        // assert that onRegsiter was called, and the proxy responded by setting its data accordingly
        $this->assertTrue( $proxy->getData() == ModelTestProxy::ON_REGISTER_CALLED,
                                "Expecting proxy.getData() == ModelTestProxy.ON_REGISTER_CALLED" );

        // Remove the component
        $model->removeProxy( ModelTestProxy::NAME );

        // assert that onRemove was called, and the proxy responded by setting its data accordingly
        $this->assertTrue( $proxy->getData() == ModelTestProxy::ON_REMOVE_CALLED,
                                "Expecting proxy.getData() == ModelTestProxy.ON_REMOVE_CALLED" );
    }

}

