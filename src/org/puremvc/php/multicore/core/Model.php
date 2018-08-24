<?php
namespace puremvc\php\multicore\core;
use puremvc\php\multicore\interfaces\IModel;
use puremvc\php\multicore\interfaces\IProxy;
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
 * A Multiton <b>IModel</b> implementation.
 *
 * In PureMVC, the <b>Model</b> class provides
 * access to model objects (Proxies) by named lookup.
 *
 * The <b>Model</b> assumes these responsibilities:
 *
 * - Maintain a cache of <b>IProxy</b> instances.
 * - Provide methods for registering, retrieving, and removing
 *   <b>IProxy</b> instances.
 *
 * Your application must register <b>IProxy</b> instances
 * with the <b>Model</b>. Typically, you use an
 * <b>ICommand</b> to create and register <b>IProxy</b>
 * instances once the <b>Facade</b> has initialized the Core
 * actors.

 * @see Proxy
        org\puremvc\php\multicore\patterns\proxy\Proxy.php
 * @see IProxy
        org\puremvc\php\multicore\interfaces\IProxy.php
 *
 * @package org.puremvc.php.multicore
 */
class Model implements IModel
{
    /**
     * Define the message content for the duplicate instance exception
     * @var string
     */
    const MULTITON_MSG = "Model instance for this Multiton key already constructed!";

    /**
     * Mapping of proxyNames to IProxy references
     * @var array
     */
    protected $proxyMap = array();

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
     * This <b>IModel</b> implementation is a Multiton, so you should not
     * call the constructor directly, but instead call the static Multiton
     * Factory method.
     *
     * ex:
     * <code>
     * Model::getInstance( 'multitonKey' )
     * </code>
     *
     * @param string $key Unique key for this instance.
     * @throws Exception if instance for this key has already been constructed
     * @return IModel Multiton instance for this key
     */
    protected function __construct( $key )
    {
        if ( isset( self::$instanceMap[ $key ] ) )
        {
            throw new Exception(self::MULTITON_MSG);
        }
        $this->multitonKey = $key;
        self::$instanceMap[ $this->multitonKey ] = $this;
        $this->proxyMap = array();
        $this->initializeModel();
    }

    /**
     * Initialize the Model instance.
     *
     * Called automatically by the constructor, this is your opportunity to
     * initialize the instance in your subclass without overriding
     * the constructor.
     *
     * @return void
     */
    protected function initializeModel(  )
    {
    }

    /**
     * Model Factory method.
     *
     * This <b>IModel</b> implementation is a Multiton so
     * this method MUST be used to get acces, or create, <b>IModel</b>s.
     *
     * @param string $key Unique key for this instance.
     * @return IModel The instance for this Multiton key
     */
    public static function getInstance( $key )
    {
        if ( !isset( self::$instanceMap[ $key ] ) )
        {
            self::$instanceMap[$key] = new Model( $key );
        }

        return self::$instanceMap[$key];
    }

    /**
     * Register Proxy
     *
     * Register an <b>IProxy</b> with the <b>Model</b>.
     *
     * @param IProxy $proxy The <b>IProxy</b> to be registered with the <b>Model</b>.
     * @return void
     */
    public function registerProxy(IProxy $proxy )
    {
        $proxy->initializeNotifier( $this->multitonKey );
        $this->proxyMap[ $proxy->getProxyName() ] = $proxy;
        $proxy->onRegister();
    }

    /**
     * Retreive Proxy
     *
     * Retrieve a previously registered <b>IProxy</b> from the <b>Model</b> by name.
     *
     * @param string $proxyName Name of the <b>IProxy</b> instance to be retrieved.
     * @return IProxy The <b>IProxy</b> previously regisetered by <var>proxyName</var> with the <b>Model</b>.
     */
    public function retrieveProxy( $proxyName )
    {
        return ( $this->hasProxy( $proxyName ) ? $this->proxyMap[ $proxyName ] : null);
    }

    /**
     * Has Proxy
     *
     * Check if a Proxy is registered for the given <var>proxyName</var>.
     *
     * @param string $proxyName Name of the <b>Proxy</b> to check for.
     * @return bool Whether a <b>Proxy</b> is currently registered with the given <var>proxyName</var>.
     */
    public function hasProxy( $proxyName )
    {
        return isset( $this->proxyMap[ $proxyName ] );
    }

    /**
     * Remove Proxy
     *
     * Remove a previously registered <b>IProxy</b> instance from the <b>Model</b> by name.
     *
     * @param string $proxyName Name of the <b>IProxy</b> to remove from the <b>Model</b>.
     * @return IProxy The <b>IProxy</b> that was removed from the <b>Model</b>.
     */
    public function removeProxy( $proxyName )
    {
        $proxy = $this->retrieveProxy( $proxyName );
        if ($proxy )
        {
            unset( $this->proxyMap[ $proxyName ] );
            $proxy->onRemove();
        }
        return $proxy;
    }

    /**
     * Remove Model
     *
     * Remove an <b>IModel</b> instance by key.
     *
     * @param string $key The multitonKey of IModel instance to remove
     * @return void
     */
    public static function removeModel( $key )
    {
        unset( self::$instanceMap[ $key ] );
    }

}
