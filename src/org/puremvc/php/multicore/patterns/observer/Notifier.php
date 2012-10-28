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
require_once 'org/puremvc/php/multicore/patterns/facade/Facade.php';

/**
 * A Base <code>INotifier</code> implementation.
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
 * <b>NOTE:</b><br>
 * In the MultiCore version of the framework, there is one caveat to
 * notifiers, they cannot send notifications or reach the facade until they
 * have a valid multitonKey.
 *
 * The multitonKey is set:
 *  - on a Command when it is executed by the Controller
 *  - on a Mediator is registered with the View
 *  - on a Proxy is registered with the Model.
 *
 * @see Proxy
        org\puremvc\php\multicore\patterns\proxy\Proxy.php
 * @see Facade
        org\puremvc\php\multicore\patterns\facade\Facade.php
 * @see Mediator
        org\puremvc\php\multicore\patterns\mediator\Mediator.php
 * @see MacroCommand
        org\puremvc\php\multicore\patterns\command\MacroCommand.php
 * @see SimpleCommand
        org\puremvc\php\multicore\patterns\command\SimpleCommand.php
 * @package org.puremvc.php.multicore
 */
class Notifier implements INotifier
{
    /**
     * Define the message content for the inexistant instance exception
     * @var string
     */
    const MULTITON_MSG = "multitonKey for this Notifier not yet initialized!";

    /**
     * The Multiton Key for this Core
     * @var string
     */
    protected $multitonKey = null;

    public function __construct()
    {
    }

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
    public function sendNotification( $notificationName, $body=null, $type=null )
    {
        if ( !is_null( $this->facade() ) )
        {
            $this->facade()->sendNotification( $notificationName, $body, $type );
        }
    }

    /**
     * Initialize this <b>INotifier</b> instance.
     *
     * This is how a Notifier gets its multitonKey.
     * Calls to sendNotification or to access the
     * facade will fail until after this method
     * has been called.
     *
     * Mediators, Commands or Proxies may override
     * this method in order to send notifications
     * or access the Multiton Facade instance as
     * soon as possible. They CANNOT access the facade
     * in their constructors, since this method will not
     * yet have been called.
     *
     * @param string $key The multitonKey for this <b>INotifier</b> to use.
     * @return void
     */
    public function initializeNotifier( $key )
    {
        $this->multitonKey = $key;
    }

    /**
     * Return the Multiton Facade instance
     *
     * @throws Exception if multitonKey for this Notifier is not yet initialized.
     * @return Facade The Facade instance for this Notifier multitonKey.
     */
    protected function facade()
    {
        if ( !isset( $this->multitonKey ) )
        {
            throw new Exception( self::MULTITON_MSG );
        }
        return Facade::getInstance( $this->multitonKey );
    }

}
