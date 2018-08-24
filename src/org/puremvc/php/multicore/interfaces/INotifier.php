<?php
namespace puremvc\php\multicore\interfaces;
/**
 * PureMVC Multicore Port to PHP
 *
 * Partly based on PureMVC Port to PHP by:
 * - Omar Gonzalez <omar@almerblank.com>
 * - and Hasan Otuome <hasan@almerblank.com>
 *
 * Created on Jully 24, 2009
 *
 * @version 1.1
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 * @author Michael Beck (https://github.com/mambax7/)
 * @copyright PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * @license http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported License
 * @package org.puremvc.php.multicore
 *
 */
/**
 *
 */

/**
 * The interface definition for a PureMVC Notifier.
 *
 * <b>MacroCommand, SimpleCommand, Mediator</b> and <b>Proxy</b>
 * all have a need to send <b>Notifications</b>.
 *
 * The <b>INotifier</b> interface provides a common method called
 * <b>sendNotification</b> that relieves implementation code of
 * the necessity to actually construct <b>Notifications</b>.
 *
 * The <b>Notifier</b> class, which all of the above mentioned classes
 * extend, also provides an initialized reference to the <b>Facade</b>
 * Singleton, which is required for the convienience method
 * for sending <b>Notifications</b>, but also eases implementation as these
 * classes have frequent <b>Facade</b> interactions and usually require
 * access to the facade anyway.
 *
 * @see IFacade
        org\puremvc\php\multicore\interfaces\IFacade.php
 * @see INotification
        org\puremvc\php\multicore\interfaces\INotification.php
 * @package org.puremvc.php.multicore
 *
 */
interface INotifier
{
    /**
     * Send a <b>INotification</b>.
     *
     * Convenience method to prevent having to construct new
     * notification instances in our implementation code.
     *
     * @param string $notificationName The name of the notification to send.
     * @param mixed $body The body of the notification (optional).
     * @param string $type The type of the notification (optional).
     * @return void
     */
    public function sendNotification( $notificationName, $body=null, $type=null );

    /**
     * Initialize this <b>INotifier</b> instance.
     *
     * This is how a Notifier gets its multitonKey.
     * Calls to sendNotification or to access the
     * facade will fail until after this method
     * has been called.
     *
     * @param string $key The multitonKey for this <b>INotifier</b> to use.
     */
    public function initializeNotifier( $key );
}
