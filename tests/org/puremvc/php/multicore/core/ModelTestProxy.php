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

use puremvc\php\multicore\patterns\proxy\Proxy;

/**
 * Used by ModelTest to test the PureMVC Model.
 * @package org.puremvc.php.multicore.unittest
 */
class ModelTestProxy extends Proxy
{

    const NAME = 'ModelTestProxy';
    const ON_REGISTER_CALLED = 'onRegister Called';
    const ON_REMOVE_CALLED = 'onRemove Called';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct ( ModelTestProxy::NAME, '' );
    }
    /**
     * Called when the Model registers a Proxy.
     */
    public function onRegister()
    {
        $this->setData( ModelTestProxy::ON_REGISTER_CALLED );
    }
    /**
     * Called when the Model removes a Proxy.
     */
    public function onRemove()
    {
        $this->setData( ModelTestProxy::ON_REMOVE_CALLED );
    }
}

?>
