<?php
/**
 * PureMVC PHP Multicore Unit Tests
 *
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 *
 * Created on Jully 24, 2009
 *
 * @version 1.0
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 * @copyright PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * @license http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported License
 * @package org.puremvc.php.multicore.unittest
 */
/**
 *
 */

require_once 'org/puremvc/php/multicore/core/Controller.php';
require_once 'org/puremvc/php/multicore/interfaces/IController.php';
require_once 'org/puremvc/php/multicore/patterns/observer/Notification.php';

require_once 'PHPUnit/Framework/TestCase.php';

require_once 'ControllerTestCommand.php';
require_once 'ControllerTestCommand2.php';
require_once 'ControllerTestVO.php';

/**
 * Test the PureMVC Controller class.
 *
 * @see ControllerTestVO
        org\puremvc\php\multicore\core\controller\ControllerTestVO.php
 * @see ControllerTestCommand
        org\puremvc\php\multicore\core\controller\ControllerTestCommand.php
 * @package org.puremvc.php.multicore.unittest
 */
class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Controller
     */
    //private $Controller;

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
     * Constructs the test case.
     */
    public function __construct()
    {
    }


    /**
     * Tests the Controller Multiton Factory Method
     */
    public function testGetInstance()
    {
        // Test Factory Method
        $controller = Controller::getInstance('ControllerTestKey1');

        // test assertions
        $this->assertTrue( $controller != null, "Expecting instance not null" );
        $this->assertTrue( $controller instanceof IController, "Expecting instance implements IController" );

        $controller2 = Controller::getInstance('ControllerTestKey1');
        $this->assertTrue( $controller === $controller2, "Expecting instances to be the same object" );

    }

    /**
     * Tests Command registration and execution.
     *
     * This test gets the Singleton Controller instance
     * and registers the ControllerTestCommand class
     * to handle 'ControllerTest' Notifications.
     *
     * It then constructs such a Notification and tells the
     * Controller to execute the associated Command.
     * Success is determined by evaluating a property
     * on an object passed to the Command, which will
     * be modified when the Command executes.
     */
    public function testRegisterAndExecuteCommand()
    {
        // Create the controller, register the ControllerTestCommand to handle 'ControllerTest' notes
        $controller = Controller::getInstance('ControllerTestKey2');
        $controller->registerCommand( 'ControllerTest', "ControllerTestCommand" );

        // Create a 'ControllerTest' note
        $vo = new ControllerTestVO( 12 );
        $note = new Notification( 'ControllerTest', $vo );

        // Tell the controller to execute the Command associated with the note
        // the ControllerTestCommand invoked will multiply the vo.input value
        // by 2 and set the result on vo.result
        $controller->executeCommand( $note );

        // test assertions
        $this->assertTrue( $vo->result == 24, "Expecting vo.result == 24" );
    }

    /**
     * Tests Command registration and removal.
     *
     * Tests that once a Command is registered and verified
     * working, it can be removed from the Controller.
     */
    public function testRegisterAndRemoveCommand()
    {
        // Create the controller, register the ControllerTestCommand to handle 'ControllerTest' notes
        $controller = Controller::getInstance('ControllerTestKey3');
        $controller->registerCommand( 'ControllerRemoveTest', "ControllerTestCommand" );

        // Create a 'ControllerTest' note
        $vo = new ControllerTestVO( 12 );
        $note = new Notification( 'ControllerRemoveTest', $vo );

        // Tell the controller to execute the Command associated with the note
        // the ControllerTestCommand invoked will multiply the vo.input value
        // by 2 and set the result on vo.result
        $controller->executeCommand( $note );

        // test assertions
        $this->assertTrue( $vo->result == 24, "Expecting vo.result == 24" );

        // Reset result
        $vo->result = 0;

        // Remove the Command from the Controller
        $controller->removeCommand( 'ControllerRemoveTest' );

        // Tell the controller to execute the Command associated with the
        // note. This time, it should not be registered, and our vo result
        // will not change
        $controller->executeCommand( $note );

        // test assertions
        $this->assertTrue( $vo->result == 0, "Expecting $vo->result == 0" );
    }

    /**
     * Tests hasCommand method.
     */
    public function testHasCommand()
    {
        // register the ControllerTestCommand to handle 'hasCommandTest' notes
        $controller = Controller::getInstance('ControllerTestKey4');
        $controller->registerCommand( 'hasCommandTest', new ControllerTestCommand() );

        // test that hasCommand returns true for hasCommandTest notifications
        $this->assertTrue( $controller->hasCommand('hasCommandTest') == true, "Expecting controller->hasCommand('hasCommandTest') == true" );

        // Remove the Command from the Controller
        $controller->removeCommand( 'hasCommandTest' );

        // test that hasCommand returns false for hasCommandTest notifications
        $this->assertTrue( $controller->hasCommand('hasCommandTest') == false, "Expecting controller->hasCommand('hasCommandTest') == false" );

    }

    /**
     * Tests Removing and Reregistering a Command
     *
     * Tests that when a Command is re-registered that it isn't fired twice.
     * This involves, minimally, registration with the controller but
     * notification via the View, rather than direct execution of
     * the Controller's executeCommand method as is done above in
     * testRegisterAndRemove.
     *
     */
    public function testReregisterAndExecuteCommand()
    {

        // Fetch the controller, register the ControllerTestCommand2 to handle 'ControllerTest2' notes
        $controller = Controller::getInstance('ControllerTestKey5');
        $controller->registerCommand('ControllerTest2', 'ControllerTestCommand2');

        // Remove the Command from the Controller
        $controller->removeCommand('ControllerTest2');

        // Re-register the Command with the Controller
        $controller->registerCommand('ControllerTest2', 'ControllerTestCommand2');

        // Create a 'ControllerTest2' note
        $vo = new ControllerTestVO( 12 );
        $note = new Notification( 'ControllerTest2', $vo );

        // retrieve a reference to the View from the same core.
        $view = View::getInstance('ControllerTestKey5');

        // send the Notification
        $view->notifyObservers($note);

        // test assertions
        // if the command is executed once the value will be 24
        $this->assertTrue( $vo->result == 24, "Expecting \$vo->result == 24" );

        // Prove that accumulation works in the VO by sending the notification again
        $view->notifyObservers($note);

        // if the command is executed twice the value will be 48
        $this->assertTrue( $vo->result == 48, "Expecting \$vo->result == 48" );

    }

}

