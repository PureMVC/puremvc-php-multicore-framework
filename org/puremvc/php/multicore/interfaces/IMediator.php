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

/**
 * The interface definition for a PureMVC Mediator.
 *
 * In PureMVC, <b>IMediator</b> implementors assume these responsibilities:
 *
 * - Implement a common method which returns a list of all <b>INotification</b>s
 *   the <b>IMediator</b> has interest in.
 * - Implement a notification callback method.
 * - Implement methods that are called when the IMediator is registered or removed from the View.
 *
 * Additionally, <b>IMediator</b>s typically:
 *
 * - Act as an intermediary between one or more view components such as text boxes or
 *   list controls, maintaining references and coordinating their behavior.
 * - This is often the place where event listeners are added to view
 *   components, and their handlers implemented.
 * - Respond to and generate <b>INotifications</b>, interacting with of
 *   the rest of the PureMVC app.
 *
 * When an <b>IMediator</b> is registered with the <b>IView</b>,
 * the <b>IView</b> will call the <b>IMediator</b>'s
 * <b>listNotificationInterests</b> method. The <b>IMediator</b> will
 * return an <b>Array</b> of <b>INotification</b> names which
 * it wishes to be notified about.
 *
 * The <b>IView</b> will then create an <b>Observer</b> object encapsulating
 * that <b>IMediator</b>'s (<b>handleNotification</b>) method and
 * register it as an Observer for each <b>INotification</b> name
 * returned by <b>listNotificationInterests</b>.
 *
 * A concrete IMediator implementor usually looks something like this:
 *
 * <code>
 * <?php
 * require_once 'org/puremvc/php/multicore/interfaces/IMediator.php';
 * require_once 'org/puremvc/php/multicore/patterns/mediator/Mediator.php';
 *
 * class MyMediator extends Mediator implements IMediator
 * {
 *     const NAME = 'MyMediator';
 *
 *     public function __construct( $mediatorName, $viewComponent = null )
 *     {
 *         parent::__construct( MyMediator::NAME, $viewComponent );
 *     }
 *
 *     public function listNotificationInterests()
 *     {
 *         return array( 'Hello', 'Bye' );
 *     }
 *
 *     public function handleNotification( INotification $notification )
 *     {
 *         switch( $notification->getName() )
 *         {
 *             case 'hello':
 *             case 'bye':
 *                 $this->outputNotificationBody( $notification );
 *                 break;
 *         }
 *     }
 *
 *     public function outputNotificationBody( $note )
 *     {
 *         print $note->body;
 *     }
 * }
 * </code>
 *
 * @see INotification
        org\puremvc\php\multicore\interfaces\INotification.php
 * @package org.puremvc.php.multicore
 *
 */
interface IMediator extends INotifier
{

    /**
     * Get Mediator Name
     *
     * Get the <b>IMediator</b> instance name
     *
     * @return string The <b>IMediator</b> instance name.
     */
    public function getMediatorName();

    /**
     * Get View Component
     *
     * Get the <b>IMediator</b>'s view component.
     *
     * @return mixed The view component
     */
    public function getViewComponent();

    /**
     * Set View Component
     *
     * Set the <b>IMediator</b>'s view component.
     *
     * @param mixed $viewComponent The view component.
     * @return void
     */
    public function setViewComponent( $viewComponent );

    /**
     * List Notifications Interests.
     *
     * List <b>INotification</b> interests.
     *
     * @return array An <b>Array</b> of the <b>INotification</b> names this <b>IMediator</b> has an interest in.
     */
    public function listNotificationInterests( );

    /**
     * Handle Notification
     *
     * Handle an <b>INotification</b>.
     *
     * @param INotification $notification The <b>INotification</b> to be handled.
     * @return void
     */
    public function handleNotification( INotification $notification );

    /**
     * onRegister event
     *
     * Called by the <b>View</b> when the <b>Mediator</b> is registered.
     *
     * @return void
     */
    public function onRegister();

    /**
     * onRemove event
     *
     * Called by the <b>View</b> when the <b>Mediator</b> is removed.
     *
     * @return void;
     */
    public function onRemove();

}
