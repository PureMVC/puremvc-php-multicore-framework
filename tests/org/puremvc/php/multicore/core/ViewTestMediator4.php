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

require_once 'org/puremvc/php/multicore/interfaces/IMediator.php';
require_once 'org/puremvc/php/multicore/patterns/mediator/Mediator.php';
/**
 * A Mediator class used by ViewTest.
 *
 * @see ViewTest
        org\puremvc\php\core\view\ViewTest.php
 * @package org.puremvc.php.multicore.unittest
 */
class ViewTestMediator4 extends Mediator implements IMediator
{
    const NAME = 'ViewTestMediator4';
    /**
     * Constructor
     */
    public function __construct( $viewComponent = null )
    {
        parent::__construct( ViewTestMediator4::NAME, $viewComponent );
    }

    /**
     *
     * @see IMediator::onRegister()
     */
    public function onRegister()
    {
        $this->viewTest()->onRegisterCalled = true;
    }

    /**
     *
     * @see IMediator::onRemove()
     */
    public function onRemove()
    {
        $this->viewTest()->onRemoveCalled = true;
    }

    /**
     * Returns the view component associated with this Mediator.
     *
     * @return mixed
     */
    public function viewTest()
    {
        return $this->viewComponent;
    }
}

?>
