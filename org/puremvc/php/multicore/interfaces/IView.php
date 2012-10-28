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
require_once 'org/puremvc/php/multicore/interfaces/INotification.php';
require_once 'org/puremvc/php/multicore/interfaces/IMediator.php';
require_once 'org/puremvc/php/multicore/interfaces/IObserver.php';

/**
 * The interface definition for a PureMVC View.
 *
 * In PureMVC, <b>IView</b> implementors assume these responsibilities:
 *
 * In PureMVC, the <b>View</b> class assumes these responsibilities:
 *
 * - Maintain a cache of <b>IMediator</b> instances.
 * - Provide methods for registering, retrieving, and removing <b>IMediators</b>.
 * - Managing the observer lists for each <b>INotification</b> in the application.
 * - Providing a method for attaching <b>IObservers</b> to an <b>INotification</b>'s observer list.
 * - Providing a method for broadcasting an <b>INotification</b>.
 * - Notifying the <b>IObservers</b> of a given <b>INotification</b> when it broadcast.
 *
 * @see IMediator
        org\puremvc\php\multicore\interfaces\IMediator.php
 * @see IObserver
        org\puremvc\php\multicore\interfaces\IObserver.php
 * @see INotification
        org\puremvc\php\multicore\interfaces\INotification.php
 * @package org.puremvc.php.multicore
 *
 */
interface IView
{

    /**
     * Register Observer
     *
     * Register an <b>IObserver</b> to be notified
     * of <b>INotifications</b> with a given name.
     *
     * @param string $notificationName The name of the <b>INotifications</b> to notify this <b>IObserver</b> of.
     * @param IObserver $observer The <b>IObserver</b> to register.
     * @return void
     */
    public function registerObserver( $notificationName, IObserver $observer );

    /**
     * Remove Observer
     *
     * Remove a group of observers from the observer list for a given Notification name.
     *
     * @param string $notificationName Which observer list to remove from.
     * @param mixed $notifyContext Remove the observers with this object as their notifyContext
     * @return void
     */
    public function removeObserver( $notificationName, $notifyContext );

    /**
     * Notify Observers
     *
     * Notify the <b>IObservers</b> for a particular <b>INotification</b>.
     *
     * All previously attached <b>IObservers</b> for this <b>INotification</b>'s
     * list are notified and are passed a reference to the <b>INotification</b> in
     * the order in which they were registered.
     *
     * @param INotification $note The <b>INotification</b> to notify <b>IObservers</b> of.
     * @return void
     */
    public function notifyObservers( INotification $notification );

    /**
     * Register Mediator
     *
     * Register an <b>IMediator</b> instance with the <b>View</b>.
     *
     * Registers the <b>IMediator</b> so that it can be retrieved by name,
     * and further interrogates the <b>IMediator</b> for its
     * <b>INotification</b> interests.
     *
     * If the <b>IMediator</b> returns any <b>INotification</b>
     * names to be notified about, an <b>Observer</b> is created encapsulating
     * the <b>IMediator</b> instance's <b>handleNotification</b> method
     * and registering it as an <b>Observer</b> for all <b>INotifications</b> the
     * <b>IMediator</b> is interested in.
     *
     * @param IMediator $mediator Reference to the <b>IMediator</b> instance.
     * @return void
     */
    public function registerMediator( IMediator $mediator );

    /**
     * Retreive Mediator
     *
     * Retrieve a previously  registered <b>IMediator</b> instance from the <b>View</b>.
     *
     * @param string $mediatorName Name of the <b>IMediator</b> instance to retrieve.
     * @return IMediator The <b>IMediator</b> previously registered with the given <var>mediatorName</var>.
     */
    public function retrieveMediator( $mediatorName );

    /**
     * Remove Mediator
     *
     * Remove a previously registered <b>IMediator</b> instance from the <b>View</b>.
     *
     * @param string $mediatorName Name of the <b>IMediator</b> instance to be removed.
     * @return IMediator The <b>IMediator</b> instance previously registered with the given <var>mediatorName</var>.
     */
    public function removeMediator( $mediatorName );

    /**
     * Has Mediator
     *
     * Check if a <b>IMediator</b> is registered or not.
     *
     * @param string $mediatorName The name of the <b>IMediator</b> to check for.
     * @return bool Boolean: Whether a <b>IMediator</b> is registered with the given <var>mediatorName</var>.
     */
    public function hasMediator( $mediatorName );

}
