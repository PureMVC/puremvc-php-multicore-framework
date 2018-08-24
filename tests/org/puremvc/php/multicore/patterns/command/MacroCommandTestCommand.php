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

require_once 'MacroCommandTestSub1Command.php';
require_once 'MacroCommandTestSub2Command.php';
/**
 * A MacroCommand subclass used by MacroCommandTest.
 *
 * @see MacroCommandTestVO
        org\puremvc\php\patterns\command\MacroCommandTestVO MacroCommandTestVO.php
 * @see MacroCommandTest
        org\puremvc\php\patterns\command\MacroCommandTest.php
 * @see MacroCommandTestSub1Command
        org\puremvc\php\patterns\command\MacroCommandTestSub1Command.php
 * @see MacroCommandTestSub2Command
        org\puremvc\php\patterns\command\MacroCommandTestSub2Command.php
 * @package org.puremvc.php.multicore.unittest
 */
class MacroCommandTestCommand extends MacroCommand
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Initialize the MacroCommandTestCommand by adding
     * its 2 SubCommands.
     */
    public function initializeMacroCommand()
    {
        $this->addSubCommand( 'MacroCommandTestSub1Command' );
        $this->addSubCommand( 'MacroCommandTestSub2Command' );
    }
}

?>
