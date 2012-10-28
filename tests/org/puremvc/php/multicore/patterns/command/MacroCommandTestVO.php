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

/**
 * A utility class used by MacroCommandTest.
 *
 * @see MacroCommandTest
        org\puremvc\php\patterns\command\MacroCommandTest.php
 * @see MacroCommandTestCommand
        org\puremvc\php\patterns\command\MacroCommandTestCommand.php
 * @see MacroCommandTestSub1Command
        org\puremvc\php\patterns\command\MacroCommandTestSub1Command.php
 * @see MacroCommandTestSub2Command
        org\puremvc\php\patterns\command\MacroCommandTestSub2Command.php
 * @package org.puremvc.php.multicore.unittest
 */
class MacroCommandTestVO
{
    public $input;
    public $result1;
    public $result2;
    /**
     * Constructor
     *
     * @param input the number to be fed to the SimpleCommandTestCommand.
     */
    function __construct( $testValue )
    {
        $this->input = $testValue;
    }
}

?>
