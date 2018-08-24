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

use puremvc\php\multicore\patterns\command\MacroCommand;
use puremvc\php\multicore\patterns\observer\Notification;

require_once 'MacroCommandTestCommand.php';
require_once 'MacroCommandTestVO.php';
/**
 * Test the PureMVC MacroCommand class.
 *
 * @see MacroCommandTestVO
        org\puremvc\php\patterns\command\MacroCommandTestVO MacroCommandTestVO.php
 * @see MacroCommandTestCommand
        org\puremvc\php\patterns\command\MacroCommandTestCommand.php
 * @package org.puremvc.php.multicore.unittest
 */
class MacroCommandTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var MacroCommand
     */
    private $MacroCommand;

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
     * Tests operation of a <b>MacroCommand</b>.
     *
     * <P>
     * This test creates a new <b>Notification</b>, adding a
     * <b>MacroCommandTestVO</b> as the body.
     * It then creates a <b>MacroCommandTestCommand</b> and invokes
     * its <b>execute</b> method, passing in the
     * <b>Notification</b>.<P>
     *
     * <P>
     * The <b>MacroCommandTestCommand</b> has defined an
     * <b>initializeMacroCommand</b> method, which is
     * called automatically by its constructor. In this method
     * the <b>MacroCommandTestCommand</b> adds 2 SubCommands
     * to itself, <b>MacroCommandTestSub1Command</b> and
     * <b>MacroCommandTestSub2Command</b>.
     *
     * <P>
     * The <b>MacroCommandTestVO</b> has 2 result properties,
     * one is set by <b>MacroCommandTestSub1Command</b> by
     * multiplying the input property by 2, and the other is set
     * by <b>MacroCommandTestSub2Command</b> by multiplying
     * the input property by itself.
     *
     * <P>
     * Success is determined by evaluating the 2 result properties
     * on the <b>MacroCommandTestVO</b> that was passed to
     * the <b>MacroCommandTestCommand</b> on the Notification
     * body.</P>
     */
    public function testMacroCommandExecute()
    {
        // Create the VO
        $vo = new MacroCommandTestVO( 5 );

        // Create the Notification (note)
        $note = new Notification( 'MacroCommandTest', $vo );

        // Create the SimpleCommand
        $command = new MacroCommandTestCommand();

        // Execute the SimpleCommand
        $command->execute( $note );

        // test assertions
        $this->assertTrue( $vo->result1 == 10, "Expecting vo->result1 == 10" );
        $this->assertTrue( $vo->result2 == 25, "Expecting vo->result2 == 25" );
    }
}

