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

require_once 'org/puremvc/php/multicore/interfaces/IObserver.php';
require_once 'org/puremvc/php/multicore/interfaces/INotification.php';

/**
 * A base <code>IObserver</code> implementation.
 *
 * An Observer is an object that encapsulates information
 * about an interested object with a notification method that
 * should be called when an </b>INotification</b> is broadcast.
 *
 * In PureMVC, <b>Observer</b> class assume these responsibilities:
 *
 * - Encapsulate the notification (callback) method of the interested object.
 * - Encapsulate the notification context (this) of the interested object.
 * - Provide methods for setting the interested object' notification method and context.
 * - Provide a method for notifying the interested object.
 *
 * @see View
        org\puremvc\php\multicore\core\View.php
 * @see Notification
        org\puremvc\php\multicore\patterns\observer\Notification.php
 * @package org.puremvc.php.multicore
 */
class Observer implements IObserver
{
    /**
     * The notification (callback) method name
     * @var string
     */
    private $notify;

    /**
     *
     * @var mixed
     */
    private $context;

    /**
     * Constructor.
     *
     * The notification method on the interested object should take
     * one parameter of type <b>INotification</b>
     *
     * @param string $notifyMethod The notification (callback) method name of the interested object.
     * @param mixed $notifyContext The notification context ($this) of the interested object.
     * @return IObserver
     */
    public function __construct( $notifyMethod, $notifyContext )
    {
        $this->setNotifyMethod( $notifyMethod );
        $this->setNotifyContext( $notifyContext );
    }

    /**
     * Set the notification method.
     *
     * The notification method should take one parameter of type <b>INotification</b>.
     *
     * @param string $notifyMethod The notification (callback) method name of the interested object.
     * @return void
     */
    public function setNotifyMethod( $notifyMethod )
    {
        $this->notify = $notifyMethod;
    }

    /**
     * Set the notification context.
     *
     * @param mixed $notifyContext The notification context ($this) of the interested object.
     * @return void
     */
    public function setNotifyContext( $notifyContext )
    {
        $this->context = $notifyContext;
    }

    /**
     * Get the notification method.
     *
     * @return string The notification (callback) method name of the interested object.
     */
    private function getNotifyMethod()
    {
        return $this->notify;
    }

    /**
     * Get the notification context.
     *
     * @return mixed The notification context ($this) of the interested object.
     */
    private function getNotifyContext()
    {
        return $this->context;
    }

    /**
     * Notify the interested object.
     *
     * @param INotification $notification the <b>INotification</b> to pass to the interested object's notification method
     * @return void
     */
    public function notifyObserver( INotification $notification )
    {
        $interested = $this->getNotifyContext();
        $method = $this->getNotifyMethod();

        $interested->$method($notification);
    }

    /**
     * Compare the given object to the notificaiton context object.
     *
     * @param object $object the object to compare.
     * @return bool Boolean indicating if the notification context and the object are the same.
     */
    public function compareNotifyContext( $object )
     {
        return ($object === $this->context);
     }
}
