<?php
namespace puremvc\php\multicore\core;
use puremvc\php\multicore\interfaces\INotification;
use puremvc\php\multicore\interfaces\IController;
use puremvc\php\multicore\patterns\observer\Observer;
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
 * A Multiton <b>IController</b> implementation.
 *
 * In PureMVC, the <b>Controller</b> class follows the
 * 'Command and Controller' strategy, and assumes these
 * responsibilities:
 *
 * - Remembering which <b>ICommand</b>s  are intended to
 *   handle which <b>INotifications</b>.
 * - Registering itself as an <b>IObserver</b> with
 *   the <b>View</b> for each <b>INotification</b>
 *   that it has an <b>ICommand</b> mapping for.
 * - Creating a new instance of the proper <b>ICommand</b>
 *   to handle a given <b>INotification</b> when notified
 *   by the <b>View</b>.
 * - Calling the <b>ICommand</b>'s <b>execute</b> method,
 *   passing in the <b>INotification</b>.
 *
 * Your application must register <b>ICommands</b> with the
 * Controller.
 *
 * The simplest way is to subclass <b>Facade</b>,
 * and use its <b>initializeController</b> method to add your
 * registrations.
 *
 * @see MacroCommand
        org\puremvc\php\multicore\patterns\command\MacroCommand.php
 * @see SimpleCommand
        org\puremvc\php\multicore\patterns\command\SimpleCommand.php
 * @see Notification
        org\puremvc\php\multicore\patterns\observer\Notification.php
 * @see Observer
        org\puremvc\php\multicore\patterns\observer\Observer.php
 * @see View
        org\puremvc\php\multicore\core\View.php
 *
 * @package org.puremvc.php.multicore
 *
 */
class Controller implements IController
{
    /**
     * Define the message content for the duplicate instance exception
     * @var string
     */
    const MULTITON_MSG = "Controller instance for this Multiton key already constructed!";

    /**
     * The view instance for this Core
     * @var IView
     */
    protected $view;

    /**
     * Mapping of Notification names to Command Class references
     * @var array
     */
    protected $commandMap;

    /**
     * The Multiton Key for this Core
     * @var string
     */
    protected $multitonKey;

    /**
     * The Multiton instances stack
     * @var array
     */
    protected static $instanceMap = array();

    /**
     * Instance constructor
     *
     * This <b>IController</b> implementation is a Multiton,
     * so you should not call the constructor
     * directly, but instead call the static <b>getInstance() Factory</b> method,
     * passing the unique key for this instance.
     *
     * ex:
     * <code>
     * $myController = MyController::getInstance( 'myMultitonKey' );
     * </code>
     *
     * @param string $key Unique key for this instance.
     * @throws Exception if instance for this key has already been constructed.
     * @return IController Instance for this key
     */
    protected function __construct( $key )
    {
        if ( isset( self::$instanceMap[ $key ] ) )
        {
            throw new Exception(self::MULTITON_MSG);
        }
        $this->multitonKey = $key;
        self::$instanceMap[ $this->multitonKey ] = $this;
        $this->commandMap = array();
        $this->initializeController();
    }

    /**
     * Initialize the instance.
     *
     * Called automatically by the constructor.
     *
     * Note that if you are using a subclass of <b>View</b> in your application,
     * you should <i>also</i> subclass <b>Controller</b> and override the <i>initializeController()</i>
     * method in the following way:
     *
     * <code>
     * // ensure that the Controller is talking to my IView implementation
     * public function initializeController( )
     * {
     *     $this->view = MyView::getInstance('myViewName');
     * }
     * </code>
     *
     * @return void
     */
    protected function initializeController(  )
    {
        $this->view = View::getInstance( $this->multitonKey );
    }

    /**
     * Controller Factory method.
     *
     * This <b>IController</b> implementation is a Multiton so
     * this method MUST be used to get acces, or create, <b>IController</b>s.
     *
     * @param string $key Unique key for this instance.
     * @return IController The instance for this Multiton key.
     */
    public static function getInstance( $key )
    {
        if ( !isset( self::$instanceMap[ $key ] ) )
        {
            self::$instanceMap[ $key ] = new Controller( $key );
        }

        return self::$instanceMap[ $key ];
    }

    /**
     * Execute Command
     *
     * Execute the <b>ICommand</b> previously registered as the
     * handler for <b>INotification</b>s with the given notification name.
     *
     * @param INotification $notification The <b>INotification</b> to execute the associated <b>Command</b> for.
     * @return void
     */
    public function executeCommand( INotification $notification )
    {
        // if the Command is registered...
        if( $this->hasCommand( $notification->getName() ) )
        {
            $commandClassName = $this->commandMap[ $notification->getName() ];
            $commandClassRef = new $commandClassName();
            $commandClassRef->initializeNotifier($this->multitonKey);
            $commandClassRef->execute( $notification );
        }
    }

    /**
     * Register Command
     *
     * Register a particular <b>ICommand</b> class as the handler
     * for a particular <b>INotification</b>.
     *
     * If an <b>ICommand</b> has already been registered to
     * handle <b>INotification</b>s with this name, it is no longer
     * used, the new <b>ICommand</b> is used instead.
     *
     * The <b>IObserver</b> for the new <b>ICommand</b> is only created if this the
     * first time an <b>ICommand</b>has been regisered for this <b>INotification</b> name.
     *
     * @param string $notificationName Name of the <b>INotification</b>.
     * @param string $commandClassRef Class name of the <b>ICommand</b> implementation to register.
     * @return void
     */
    public function registerCommand( $notificationName, $commandClassRef )
    {
        if ( !$this->hasCommand( $notificationName ) )
        {
            $this->view->registerObserver( $notificationName, new Observer( "executeCommand", $this ) );
        }
        $this->commandMap[ $notificationName ] = $commandClassRef;
    }

    /**
     * Has Command
     *
     * Check if a <b>ICommand</b> is <b>registerCommand() registered</b> for a given <b>INotification</b>
     *
     * @param string $notificationName Name of the <b>INotification</b> to check for.
     * @return bool Whether a <b>ICommand</b> is currently registered for the given <var>notificationName</var>.
     */
    public function hasCommand( $notificationName )
    {
        return isset( $this->commandMap[ $notificationName ] );
    }

    /**
     * Remove Command
     *
     * Remove a previously <b>registerCommand() registered</b> <b>ICommand</b> to <b>INotification</b> mapping.
     *
     * @param string $notificationName Name of the <b>INotification</b> to remove the <b>ICommand</b> mapping for.
     * @return void
     */
    public function removeCommand( $notificationName )
    {
        // if the Command is registered...
        if ( $this->hasCommand( $notificationName ) )
        {
            // remove the observer
            $this->view->removeObserver( $notificationName, $this );

            // remove the command
            unset( $this->commandMap[ $notificationName ] );
        }
    }

    /**
     * Remove controller
     *
     * Remove an <b>IController</b> instance identified by it's <b>key</b>
     *
     * @param string $key multitonKey of <b>IController</b> instance to remove
     * @return void
     */
    public static function removeController( $key )
    {
        unset( self::$instanceMap[ $key ] );
    }

}
