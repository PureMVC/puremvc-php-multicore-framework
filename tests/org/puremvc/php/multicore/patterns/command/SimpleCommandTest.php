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

use puremvc\php\multicore\patterns\command\SimpleCommand;
use puremvc\php\multicore\patterns\observer\Notification;



require_once 'SimpleCommandTestCommand.php';
require_once 'SimpleCommandTestVO.php';

/**
 * Test the PureMVC SimpleCommand class.
 *
 * @see SimpleCommandTestVO
        org\puremvc\php\patterns\command\SimpleCommandTestVO.php
 * @see SimpleCommandTestCommand
        org\puremvc\php\patterns\command\SimpleCommandTestCommand.php
 * @package org.puremvc.php.multicore.unittest
 */
class SimpleCommandTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var SimpleCommand
     */
    private $SimpleCommand;

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
     * Tests the <b>execute</b> method of a <b>SimpleCommand</b>.
     *
     * <P>
     * This test creates a new <b>Notification</b>, adding a
     * <b>SimpleCommandTestVO</b> as the body.
     * It then creates a <b>SimpleCommandTestCommand</b> and invokes
     * its <b>execute</b> method, passing in the note.</P>
     *
     * <P>
     * Success is determined by evaluating a property on the
     * object that was passed on the Notification body, which will
     * be modified by the SimpleCommand</P>.
     */
    public function testSimpleCommandExecute()
    {
        // Create the VO
        $vo = new SimpleCommandTestVO( 5 );

        // Create the Notification (note)
        $note = new Notification( 'SimpleCommandTestNote', $vo );

        // Create the SimpleCommand
        $command = new SimpleCommandTestCommand();

        // Execute the SimpleCommand
        $command->execute( $note );

        // test assertions
        $this->assertTrue( $vo->result == 10, "Expecting vo.result == 10" );
    }
}

