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

use puremvc\php\multicore\interfaces\INotification;
use puremvc\php\multicore\patterns\command\SimpleCommand;
/**
 * A SimpleCommand subclass used by MacroCommandTestCommand.
 *
 * @see MacroCommandTest
        org\puremvc\php\patterns\command\MacroCommandTest.php
 * @see MacroCommandTestCommand
        org\puremvc\php\patterns\command\MacroCommandTestCommand.php
 * @see MacroCommandTestVO
        org\puremvc\php\patterns\command\MacroCommandTestVO.php
 * @package org.puremvc.php.multicore.unittest
 */
class MacroCommandTestSub2Command extends SimpleCommand
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Fabricate a result by multiplying the input by 2
     *
     * @param INotification $note the Notification carrying the FacadeTestVO
     */
    public function execute( INotification $note )
    {
        $vo = $note->getBody();
        $vo->result2 = $vo->input * $vo->input;
    }
}

?>
