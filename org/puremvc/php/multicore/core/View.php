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

require_once 'org/puremvc/php/multicore/interfaces/IView.php';
require_once 'org/puremvc/php/multicore/interfaces/IObserver.php';
require_once 'org/puremvc/php/multicore/interfaces/INotification.php';
require_once 'org/puremvc/php/multicore/interfaces/IMediator.php';

/**
 * A Multiton <b>IView</b> implementation.
 *
 * In PureMVC, the <b>View</b> class assumes these responsibilities:
 *
 * - Maintain a cache of <b>IMediator</b> instances.
 * - Provide methods for registering, retrieving, and removing <b>IMediators</b>.
 * - Notifiying <b>IMediators</b> when they are registered or removed.
 * - Managing the observer lists for each <b>INotification<b> in the application.
 * - Providing a method for attaching <b>IObservers</b> to an <b>INotification</b>'s observer list.
 * - Providing a method for broadcasting an <b>INotification</b>.
 * - Notifying the <b>IObservers</b> of a given <b>INotification</b> when it broadcast.
 *
 * @see Mediator
        org\puremvc\php\multicore\patterns\mediator\Mediator.php
 * @see Observer
        org\puremvc\php\multicore\patterns\observer\Observer.php
 * @see Notification
        org\puremvc\php\multicore\patterns\observer\Notification.php
 *
 * @package org.puremvc.php.multicore
 */
class View implements IView
{
    /**
     * Define the message content for the duplicate instance exception
     * @var string
     */
    const MULTITON_MSG = "View instance for this Multiton key already constructed!";

    /**
     * Mapping of mediatorNames to IMediator references
     * @var array
     */
    protected $mediatorMap = array();

    /**
     * Mapping of Notification names to Observer lists
     * @var array
     */
    protected $observerMap  = array();

    /**
     * The Multiton Key for this Core
     * @var string
     */
    protected $multitonKey = NULL;

    /**
     * The Multiton instances stack
     * @var array
     */
    protected static $instanceMap = array();

    /**
     * Constructor.
     *
     * This <b>IView</b> implementation is a Multiton,
     * so you should not call the constructor
     * directly, but instead call the static Multiton
     * Factory method.
     *
     * <code>
     * View::getInstance( 'multitonKey' );
     * </code>
     *
     * @param string $key Unique key for this instance.
     * @throws Exception if instance for this key has already been constructed.
     * @return IView Instance for this key
     */
    protected function __construct( $key )
    {
        if ( isset( self::$instanceMap[ $key ] ) )
        {
            throw new Exception(self::MULTITON_MSG);
        }
        $this->multitonKey = $key;
        self::$instanceMap[ $this->multitonKey ] = $this;
        $this->mediatorMap = array();
        $this->observerMap = array();
        $this->initializeView();
    }

    /**
     * Initialize the Singleton View instance.
     *
     * Called automatically by the constructor, this
     * is your opportunity to initialize the Multiton
     * instance in your subclass without overriding the
     * constructor.
     *
     * @return void
     */
    protected function initializeView(  )
    {
    }

    /**
     * View Factory method.
     *
     * This <b>IView</b> implementation is a Multiton so
     * this method MUST be used to get acces, or create, <b>IView</b>s.
     *
     * @param string $key Unique key for this instance.
     * @return IView The instance for this Multiton key.
     */
    public static function getInstance( $key )
    {
        if ( !isset( self::$instanceMap[ $key ] ) )
        {
            self::$instanceMap[ $key ] = new View( $key );
        }
        return self::$instanceMap[ $key ];
    }

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
    public function registerObserver ( $notificationName, IObserver $observer)
    {
        if( isset( $this->observerMap[ $notificationName ] ) )
        {
            array_push($this->observerMap[ $notificationName ], $observer );
        }
        else
        {
            $this->observerMap[ $notificationName ] = array( $observer );
        }
    }


    /**
     * Notify Observers
     *
     * Notify the <b>IObservers</b> for a particular <b>INotification</b>.
     *
     * All previously attached <b>IObservers</b> for this <b>INotification</b>'s
     * list are notified and are passed a reference to the <b>INotification</b> in
     * the order in which they were registered.
     *
     * @param INotification $notification The <b>INotification</b> to notify <b>IObservers</b> of.
     * @return void
     */
    public function notifyObservers( INotification $notification )
    {
        if( isset( $this->observerMap[ $notification->getName() ] ) )
        {
            // Get a reference to the observers list for this notification name
            $observers_ref = $this->observerMap[ $notification->getName() ];

            // Copy observers from reference array to working array,
            // since the reference array may change during the notification loop
            $observers = array();
            foreach($observers_ref as $observer)
            {
                array_push( $observers, $observer );
            }

            // Notify Observers from the working array
            foreach($observers as $observer)
            {
                $observer->notifyObserver( $notification );
            }
        }
    }

    /**
     * Remove Observer
     *
     * Remove a group of observers from the observer list for a given Notification name.
     *
     * @param string $notificationName Which observer list to remove from.
     * @param mixed $notifyContext Remove the observers with this object as their notifyContext
     * @return void
     */
    public function removeObserver( $notificationName, $notifyContext )
    {
        //Is there registered Observers for the notification under inspection
        if( !isset( $this->observerMap[ $notificationName ] )) return;

        // the observer list for the notification under inspection
        $observers = $this->observerMap[ $notificationName ];

        // find the observer for the notifyContext
        for ( $i = 0; $i < count( $observers ); $i++ )
        {
            if ( $observers[$i]->compareNotifyContext( $notifyContext ) == true )
            {
                // there can only be one Observer for a given notifyContext
                // in any given Observer list, so remove it and break
                array_splice($observers,$i,1);
                break;
            }
        }

        // Also, when a Notification's Observer list length falls to
        // zero, delete the notification key from the observer map
        if ( count( $observers ) == 0 )
        {
            unset($this->observerMap[ $notificationName ]);
        }
    }

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
    public function registerMediator( IMediator $mediator )
    {

        // do not allow re-registration (you must to removeMediator fist)
        if ( $this->hasMediator( $mediator->getMediatorName() ) ) return;

        $mediator->initializeNotifier( $this->multitonKey );

        // Register the Mediator for retrieval by name
        $this->mediatorMap[ $mediator->getMediatorName() ] = $mediator;

        // Get Notification interests, if any.
        $interests = array();
        $interests = $mediator->listNotificationInterests();

        // Register Mediator as an observer for each notification of interests
        if ( count( $interests ) > 0 )
        {
            // Create Observer referencing this mediator's handlNotification method
            $observer = new Observer( "handleNotification", $mediator );

            // Register Mediator as Observer for its list of Notification interests
            for ( $i = 0;  $i < count( $interests ); $i++ )
            {
                $this->registerObserver( $interests[$i],  $observer );
            }
        }

        // alert the mediator that it has been registered
        $mediator->onRegister();

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
        return ( $this->hasMediator( $mediatorName ) ? $this->mediatorMap[ $mediatorName ] : null );
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
        // Retrieve the named mediator
        $mediator = $this->retrieveMediator( $mediatorName );

        if ( $mediator )
        {
            // for every notification this mediator is interested in...
            $interests = $mediator->listNotificationInterests();
            for ( $i = 0; $i < count( $interests ); $i++ )
            {
                // remove the observer linking the mediator
                // to the notification interest
                $this->removeObserver( $interests[$i], $mediator );
            }

            // remove the mediator from the map
            unset($this->mediatorMap[ $mediatorName ]);

            // alert the mediator that it has been removed
            $mediator->onRemove();
        }

        return $mediator;
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
        return isset( $this->mediatorMap[ $mediatorName ] );
    }

    /**
     * Remove View
     *
     * Remove an <b>IView</b> instance by key.
     *
     * @param string $key The multitonKey of IView instance to remove
     * @return void
     */
    public static function removeView( $key )
    {
        unset( self::$instanceMap[ $key ] );
    }

}
