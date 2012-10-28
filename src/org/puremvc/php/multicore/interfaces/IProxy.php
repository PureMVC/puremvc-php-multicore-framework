<?php
/**
 * PureMVC Multicore Port to PHP
 *
 * Partly based on PureMVC Port to PHP by:
 * - Omar Gonzalez <omar@almerblank.com>
 * - and Hasan Otuome <hasan@almerblank.com>
 *
 * Created on Jully 24, 2009
 *
 * @version 1.0
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 * @copyright PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * @license http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported License
 * @package org.puremvc.php.multicore
 *
 */
/**
 *
 */

require_once 'org/puremvc/php/multicore/interfaces/INotifier.php';

/**
 * The interface definition for a PureMVC Proxy.
 *
 * In PureMVC, <b>IProxy</b> implementors assume these responsibilities:</P>
 *
 * - Implement a common method which returns the name of the Proxy.
 * - Provide methods for setting and getting the data object.
 *
 * Additionally, <b>IProxy</b>s typically:
 *
 * - Maintain references to one or more pieces of model data.
 * - Provide methods for manipulating that data.
 * - Generate <b>INotifications</b> when their model data changes.
 * - Expose their name as a <b>public static const</b> called <b>NAME</b>, if they are not instantiated multiple times.
 * - Encapsulate interaction with local or remote services used to fetch and persist model data.
 *
 * @package org.puremvc.php.multicore
 */
interface IProxy extends INotifier
{

    /**
     * Get the Proxy name
     *
     * @return string The Proxy instance name
     */
    public function getProxyName();

    /**
     * Data setter
     *
     * Set the data object
     *
     * @param mixed $data the data object
     * @return void
     */
    public function setData( $data );

    /**
     * Data getter
     *
     * Get the data object
     *
     * @return mixed The data Object. null if not set
     */
    public function getData();

    /**
     * onRegister event
     *
     * Called by the Model when the Proxy is registered
     *
     * @return void
     */
    public function onRegister();

    /**
     * onRemove event
     * Called by the Model when the Proxy is removed
     *
     * @return void
     */
    public function onRemove();

}
