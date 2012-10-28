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

// Define path to PureMVC PHP Multicore directory
// Replace this with the absolute location of your copy of 
// PureMVC PHP Multicore Library or copy the library into the root
// of this project and set this constant to ''
defined('PUREMVC_PHP_MULTICORE_LIBRARY_PATH')
    || define('PUREMVC_PHP_MULTICORE_LIBRARY_PATH', 'D:/eclipse/Workspaces/PureMVC_PHP_MultiCore_1_0_0;');


set_include_path(PUREMVC_PHP_MULTICORE_LIBRARY_PATH.get_include_path());

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'org/puremvc/php/multicore/core/ControllerTest.php';
require_once 'org/puremvc/php/multicore/core/ModelTest.php';
require_once 'org/puremvc/php/multicore/core/ViewTest.php';

require_once 'org/puremvc/php/multicore/patterns/command/MacroCommandTest.php';
require_once 'org/puremvc/php/multicore/patterns/command/SimpleCommandTest.php';
require_once 'org/puremvc/php/multicore/patterns/facade/FacadeTest.php';
require_once 'org/puremvc/php/multicore/patterns/mediator/MediatorTest.php';
require_once 'org/puremvc/php/multicore/patterns/observer/NotificationTest.php';
require_once 'org/puremvc/php/multicore/patterns/observer/ObserverTest.php';
require_once 'org/puremvc/php/multicore/patterns/proxy/ProxyTest.php';

/**
 * Static test suite.
 * @package org.puremvc.php.multicore.unittest
 */
class AllTestsSuite extends PHPUnit_Framework_TestSuite
{
    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName( 'AllTestsSuite' );
        $this->addTestSuite( 'ControllerTest' );
        $this->addTestSuite( 'ModelTest' );
        $this->addTestSuite( 'MediatorTest' );
        $this->addTestSuite( 'ProxyTest' );
        $this->addTestSuite( 'NotificationTest' );
        $this->addTestSuite( 'ObserverTest' );
        $this->addTestSuite( 'FacadeTest' );
        $this->addTestSuite( 'SimpleCommandTest' );
        $this->addTestSuite( 'MacroCommandTest' );
        $this->addTestSuite( 'ViewTest' );
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

