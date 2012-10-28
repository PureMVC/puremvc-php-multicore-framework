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

require_once 'org/puremvc/php/multicore/interfaces/IProxy.php';

/**
 * The interface definition for a PureMVC Model.
 *
 * In PureMVC, <b>IModel</b> implementors provide
 * access to <b>IProxy</b> objects by named lookup.
 *
 * An <b>IModel</b> assumes these responsibilities:
 *
 * - Maintain a cache of <b>IProxy</b> instances.
 * - Provide methods for registering, retrieving, and removing <b>IProxy</b> instances.
 *
 *
 * @package org.puremvc.php.multicore
 */
interface IModel
{
    /**
     * Register Proxy
     *
     * Register an <b>IProxy</b> with the <b>Model</b>.
     *
     * @param IProxy $proxy The <b>IProxy</b> to be registered with the <b>Model</b>.
     * @return void
     */
    public function registerProxy( IProxy $proxy );

    /**
     * Retreive Proxy
     *
     * Retrieve a previously registered <b>IProxy</b> from the <b>Model</b> by name.
     *
     * @param string $proxyName Name of the <b>IProxy</b> instance to be retrieved.
     * @return IProxy The <b>IProxy</b> previously regisetered by <var>proxyName</var> with the <b>Model</b>.
     */
    public function retrieveProxy( $proxyName );

    /**
     * Remove Proxy
     *
     * Remove a previously registered <b>IProxy</b> instance from the <b>Model</b> by name.
     *
     * @param string $proxyName Name of the <b>IProxy</b> to remove from the <b>Model</b>.
     * @return IProxy The <b>IProxy</b> that was removed from the <b>Model</b>.
     */
    public function removeProxy( $proxyName );

    /**
     * Has Proxy
     *
     * Check if a Proxy is registered for the given <var>proxyName</var>.
     *
     * @param string $proxyName Name of the <b>Proxy</b> to check for.
     * @return bool Boolean: Whether a <b>Proxy</b> is currently registered with the given <var>proxyName</var>.
     */
    public function hasProxy( $proxyName );

}
