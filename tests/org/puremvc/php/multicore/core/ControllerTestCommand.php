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
use puremvc\php\multicore\interfaces\INotification;

/**
 * A SimpleCommand subclass used by ControllerTest.
 *
 * @see ControllerTest
        org\puremvc\php\core\controller\ControllerTest.php
 * @see ControllerTestVO
        org\puremvc\php\core\controller\ControllerTestVO.php
 * @package org.puremvc.php.multicore.unittest
 */
class ControllerTestCommand extends SimpleCommand
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Fabricate a result by multiplying the input by 2.
     *
     * @param INotification $note the note carrying the ControllerTestVO
     */
    public function execute( INotification $note )
    {
        $vo = $note->getBody();
        $vo->result = 2 * $vo->input;
    }
}
