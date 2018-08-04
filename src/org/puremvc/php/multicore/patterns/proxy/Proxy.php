<?php
namespace puremvc\php\multicore\patterns\proxy;
use puremvc\php\multicore\interfaces\IProxy;
use puremvc\php\multicore\patterns\observer\Notifier;
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
 * A base <b>IProxy</b> implementation.
 *
 * In PureMVC, Proxy classes are used to manage parts of the
 * application's data model.
 *
 * A <b>Proxy</b> might simply manage a reference to a local data object,
 * in which case interacting with it might involve setting and
 * getting of its data in synchronous fashion.
 *
 * <b>Proxy</b> classes are also used to encapsulate the application's
 * interaction with remote services to save or retrieve data, in which case,
 * we adopt an asyncronous idiom; setting data (or calling a method) on the
 * <b>Proxy</b> and listening for a <b>Notification</b> to be sent
 * when the <b>Proxy</b> has retrieved the data from the service.
 *
 * @see Notifier
        org\puremvc\php\multicore\patterns\observer\Notifier.php
 * @see Model
        org\puremvc\php\multicore\core\Model.php
 * @package org.puremvc.php.multicore
 */
class Proxy extends Notifier implements IProxy
{

    /**
     * Define the default name of the proxy
     * @var string
     */
    const NAME = 'Proxy';

    /**
     * The name of the proxy
     * @var string
     */
    protected $proxyName;

    /**
     * The data object managed by the proxy
     * @var mixed
     */
    protected $data;

    /**
     * Constructor
     *
     * @param string $proxyName [OPTIONAL] Name for the proxy instance will default to <samp>Proxy::NAME</samp> if not set.
     * @param mixed $data [OPTIONAL] Data object to be managed by the proxy may be set later with <samp>setData()</samp>.
     */
    public function __construct( $proxyName=null, $data=null )
    {
        $this->proxyName = !empty( $proxyName ) ? $proxyName : Proxy::NAME;
        $this->setData($data);
    }

    /**
     * Get the Proxy name
     *
     * @return string The Proxy instance name
     */
    public function getProxyName()
    {
        return $this->proxyName;
    }

    /**
     * Data setter
     *
     * Set the data object
     *
     * @param mixed $data the data object
     * @return void
     */
    public function setData( $data )
    {
        if ( !is_null( $data ) )
        {
            $this->data = $data;
        }
    }

    /**
     * Data getter
     *
     * Get the data object
     *
     * @return mixed The data Object. null if not set.
     */
    public function getData()
    {
        return ( isset($this->data) ? $this->data : null );
    }

    /**
     * onRegister event
     *
     * Called by the Model when the Proxy is registered
     *
     * @return void
     */
    public function onRegister( )
    {
    }

    /**
     * onRemove event
     * Called by the Model when the Proxy is removed
     *
     * @return void
     */
    public function onRemove( )
    {
    }

}
