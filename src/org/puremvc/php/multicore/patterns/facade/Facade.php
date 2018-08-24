<?php
namespace puremvc\php\multicore\patterns\facade;
use puremvc\php\multicore\core\Controller;
use puremvc\php\multicore\core\Model;
use puremvc\php\multicore\core\View;
use puremvc\php\multicore\interfaces\IFacade;
use puremvc\php\multicore\interfaces\IMediator;
use puremvc\php\multicore\interfaces\INotification;
use puremvc\php\multicore\interfaces\IProxy;
use puremvc\php\multicore\patterns\observer\Notification;

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
 * A base Multiton <b>IFacade</b> implementation.
 *
 * The Facade Pattern suggests providing a single
 * class to act as a central point of communication
 * for a subsystem.
 *
 * In PureMVC, the Facade acts as an interface between
 * the core MVC actors ( Model, View, Controller) and
 * the rest of your application.
 *
 * @package org.puremvc.php.multicore
 * @see Model
        org\puremvc\php\multicore\core\Model.php
 * @see View
        org\puremvc\php\multicore\core\View.php
 * @see Controller
        org\puremvc\php\multicore\core\Controller.php
 */
class Facade implements IFacade
{
    /**
     * Define the message content for the duplicate instance exception
     * @var string
     */
    const MULTITON_MSG = "Facade instance for this Multiton key already constructed!";

    /**
     * The controller instance for this Core
     * @var Controller
     */
    protected $controller;

    /**
     * The model instance for this Core
     * @var Model
     */
    protected $model;

    /**
     * The view instance for this Core
     * @var View
     */
    protected $view;

    /**
     * The Multiton Key for this Core
     * @var string
     */
    protected $multitonKey;

    /**
     * The Multiton Facade instances stack.
     * @var array
     */
    protected static $instanceMap = array();

    /**
     * Instance constructor
     *
     * This <b>IFacade</b> implementation is a Multiton,
     * so you should not call the constructor
     * directly, but instead call the static Factory method,
     * passing the unique key for this instance
     *
     * <code>
     * Facade::getInstance( 'multitonKey' )
     * </code>
     *
     * @param string $key Unique key for this instance.
     * @throws Exception if instance for this key has already been constructed.
     * @return IFacade Instance for this key
     */
    protected function __construct( $key )
    {
        if (isset(self::$instanceMap[ $key ]))
        {
            throw new Exception(MULTITON_MSG);
        }
        $this->initializeNotifier( $key );
        self::$instanceMap[ $this->multitonKey ] = $this;
        $this->initializeFacade();
    }

    /**
     * Initialize the <b>Facade</b> instance.
     *
     * Called automatically by the constructor. Override in your
     * subclass to do any subclass specific initializations. Be
     * sure to call <samp>parent::initializeFacade()</samp>, though.
     *
     * @return void
     */
    protected function initializeFacade(  )
    {
        $this->initializeModel();
        $this->initializeController();
        $this->initializeView();
    }

    /**
     * <b>Facade</b> Multiton Factory method
     *
     * This <b>IFacade</b> implementation is a Multiton,
     * so you MUST not call the constructor
     * directly, but instead call this static Factory method,
     * passing the unique key for this instance
     *
     * @param string $key Unique key for this instance.
     * @return IFacade Instance for this key
     */
    public static function getInstance( $key )
    {
        if (!isset( self::$instanceMap[ $key ] ) )
        {
            self::$instanceMap[ $key ] = new Facade( $key );
        }
        return self::$instanceMap[ $key ];
    }

    /**
     * Initialize the <b>Controller</b>.
     *
     * Called by the <b>initializeFacade()</b> method.
     *
     * Override this method in your subclass of <b>Facade</b> if
     * one or both of the following are true:
     *
     * - You wish to initialize a different <b>Controller</b>.
     * - You have <b>Commands</b> to register with the <b>Controller</b> at startup.
     *
     * If you don't want to initialize a different <b>Controller</b>,
     * call <samp>parent::initializeController()</samp> at the beginning of your
     * method, then register Commands.
     *
     * @return void
     */
    protected function initializeController( )
    {
        if ( isset( $this->controller ) ) return;

        $this->controller = Controller::getInstance( $this->multitonKey );
    }

    /**
     * Initialize the <b>Model</b>.
     *
     * Called by the <b>initializeFacade()</b> method.
     *
     * Override this method in your subclass of <b>Facade</b> if
     * one or both of the following are true:
     *
     * - You wish to initialize a different <b>Model</b>.
     * - You have <b>Proxys</b> to register with the <b>Model</b> that do not<br>
     *   retrieve a reference to the <b>Facade</b> at construction time.
     *
     * If you don't want to initialize a different <b>Model</b>,
     * call <b>parent::initializeModel()</b> at the beginning of your
     * method, then register <b>Proxys</b>.
     *
     * <b>Note:</b><br>
     * This method is <i>rarely</i> overridden; in practice you are more
     * likely to use a <b>Command</b> to create and register <b>Proxys</b>
     * with the <b>Model</b>, since <b>Proxys</b> with mutable data will likely
     * need to send <b>Notifications</b> and thus will likely want to fetch a reference to
     * the <b>Facade</b> during their construction.
     *
     * @return void
     */
    protected function initializeModel( )
    {
        if ( isset( $this->model ) ) return;

        $this->model = Model::getInstance( $this->multitonKey );
    }


    /**
     * Initialize the <b>View</b>.
     *
     * Called by the <b>initializeFacade()</b> method.
     *
     * Override this method in your subclass of <b>Facade</b>
     * if one or both of the following are true:
     *
     * - You wish to initialize a different <b>IView</b> implementation.
     * - You have <b>Observer</b>s to register with the <b>View</b>
     *
     * If you don't want to initialize a different <code>IView</code>,
     * call <code>super.initializeView()</code> at the beginning of your
     * method, then register <code>IMediator</code> instances.
     *
     * <b>Note:</b><br>
     * This method is <i>rarely</i> overridden; in practice you are more
     * likely to use a Command to create and register Mediators
     * with the View, since IMediator instances will need to send
     * INotifications and thus will likely want to fetch a reference
     * to the Facade during their construction.
     *
     * @return void
     */
    protected function initializeView( )
    {
        if ( isset( $this->view ) ) return;

        $this->view = View::getInstance( $this->multitonKey );
    }

    /**
     * Register Proxy
     *
     * Register an <b>IProxy</b> with the <b>Model</b>.
     *
     * @param IProxy $proxy The <b>IProxy</b> to be registered with the <b>Model</b>.
     * @return void
     */
    public function registerProxy ( IProxy $proxy )
    {
        if( isset( $this->model ) )
        {
            $this->model->registerProxy( $proxy );
        }
    }

    /**
     * Retreive Proxy
     *
     * Retrieve a previously registered <b>IProxy</b> from the <b>Model</b> by name.
     *
     * @param string $proxyName Name of the <b>IProxy</b> instance to be retrieved.
     * @return IProxy The <b>IProxy</b> previously regisetered by <var>proxyName</var> with the <b>Model</b>.
     */
    public function retrieveProxy ( $proxyName )
    {
        return ( isset( $this->model ) ? $this->model->retrieveProxy( $proxyName ) : null );
    }

    /**
     * Remove Proxy
     *
     * Remove a previously registered <b>IProxy</b> instance from the <b>Model</b> by name.
     *
     * @param string $proxyName Name of the <b>IProxy</b> to remove from the <b>Model</b>.
     * @return IProxy The <b>IProxy</b> that was removed from the <b>Model</b>.
     */
    public function removeProxy ( $proxyName )
    {
        return ( isset( $this->model ) ? $this->model->removeProxy( $proxyName ): null);
    }

    /**
     * Has Proxy
     *
     * Check if a Proxy is registered for the given <var>proxyName</var>.
     *
     * @param string $proxyName Name of the <b>Proxy</b> to check for.
     * @return bool Boolean: Whether a <b>Proxy</b> is currently registered with the given <var>proxyName</var>.
     */
    public function hasProxy( $proxyName )
    {
        return ( isset( $this->model ) ? $this->model->hasProxy( $proxyName ) : false );
    }

    /**
     * Register Command
     *
     * Register an <b>ICommand</b> with the <b>Controller</b>.
     *
     * @param string $noteName Name of the <b>INotification</b>
     * @param object|string $commandClassRef <b>ICommand</b> object to register. Can be an object OR a class name.
     * @return void
     */
    public function registerCommand( $notificationName, $commandClassRef)
    {
        if( isset( $this->controller ) )
        {
            $this->controller->registerCommand( $notificationName, $commandClassRef );
        }
    }
    /**
     * Remove Command
     *
     * Remove a previously registered <b>ICommand</b> to <b>INotification</b> mapping.
     *
     * @param string $notificationName Name of the <b>INotification</b> to remove the <b>ICommand</b> mapping for.
     */
    public function removeCommand( $notificationName )
    {
        if( isset( $this->controller ) )
        {
            $this->controller->removeCommand( $notificationName );
        }
    }

    /**
     * Has Command
     *
     * Check if a <b>Command</b> is registered for a given <b>Notification</b>
     *
     * @param string $notificationName Name of the <b>INotification</b> to check for.
     * @return bool Whether a <b>Command</b> is currently registered for the given <var>notificationName</var>.
     */
    public function hasCommand( $notificationName )
    {
        return ( isset( $this->controller ) ? $this->controller->hasCommand($notificationName) : false );
    }

    /**
     * Register Mediator
     *
     * Register an <b>IMediator</b> instance with the <b>View</b>.
     *
     * @param IMediator $mediator Reference to the <b>IMediator</b> instance.
     */
    public function registerMediator( IMediator $mediator )
    {
        if ( isset( $this->view ) )
        {
            $this->view->registerMediator( $mediator );
        }
    }

    /**
     * Retreive Mediator
     *
     * Retrieve a previously registered <b>IMediator</b> instance from the <b>View</b>.
     *
     * @param string $mediatorName Name of the <b>IMediator</b> instance to retrieve.
     * @return IMediator The <b>IMediator</b> previously registered with the given <var>mediatorName</var>.
     */
    public function retrieveMediator( $mediatorName )
    {
        return ( isset( $this->view ) ? $this->view->retrieveMediator( $mediatorName ) : null );
    }

    /**
     * Remove Mediator
     *
     * Remove a previously registered <b>IMediator</b> instance from the <b>View</b>.
     *
     * @param string $mediatorName Name of the <b>IMediator</b> instance to be removed.
     * @return IMediator The <b>IMediator</b> instance previously registered with the given <var>mediatorName</var>.
     */
    public function removeMediator( $mediatorName )
    {
        return ( isset( $this->view ) ? $this->view->removeMediator( $mediatorName ): null);
    }

    /**
     * Has Mediator
     *
     * Check if a <b>IMediator</b> is registered or not.
     *
     * @param string $mediatorName The name of the <b>IMediator</b> to check for.
     * @return bool Boolean: Whether a <b>IMediator</b> is registered with the given <var>mediatorName</var>.
     */
    public function hasMediator( $mediatorName )
    {
        return ( isset( $this->view ) ? $this->view->hasMediator( $mediatorName ) : false );
    }

    /**
     * Create and send an <b>INotification</b>.
     *
     * Keeps us from having to construct new notification
     * instances in our implementation code.
     *
     * @param string $notificationName The name of the notification to send.
     * @param mixed $body The body of the notification (optional).
     * @param string $type The type of the notification (optional).
     * @return void
     */
    public function sendNotification( $notificationName , $body =null, $type=null )
    {
        $this->notifyObservers( new Notification( $notificationName, $body, $type ) );
    }

    /**
     * Notify <b>Observer</b>s.
     *
     * This method is left public mostly for backward
     * compatibility, and to allow you to send custom
     * notification classes using the facade.
     *
     * Usually you should just call sendNotification
     * and pass the parameters, never having to
     * construct the notification yourself.
     *
     * @param INotification $notification The <b>INotification</b> to have the <b>View</b> notify <b>Observers</b> of.
     * @return void
     */
    public function notifyObservers ( INotification $notification )
    {
        if ( isset( $this->view ) )
        {
            $this->view->notifyObservers( $notification );
        }
    }

    /**
     * Set the Multiton key for this facade instance.
     *
     * Not called directly, but instead from the
     * constructor when getInstance is invoked.
     * It is necessary to be public in order to
     * implement INotifier.
     *
     * @param string $key Unique key for this instance.
     * @return void
     */
    public function initializeNotifier( $key )
    {
        $this->multitonKey = $key;
    }

    /**
     * Check if a Core is registered or not
     *
     * @param string $key the multiton key for the Core in question
     * @return bool Whether a Core is registered with the given <code>key</code>.
     */
    public static function hasCore( $key )
    {
        return ( isset( self::$instanceMap[ $key ] ) );
    }

    /**
     * Remove a Core.
     *
     * Remove the Model, View, Controller and Facade
     * instances for the given key.
     *
     * @param string $key MultitonKey of the Core to remove
     * @return void
     */
    public static function removeCore( $key )
    {
        if ( !self::hasCore( $key ) ) return;

        Model::removeModel( $key );
        View::removeView( $key );
        Controller::removeController( $key );
        self::$instanceMap[ $key ] = null;
    }

}
