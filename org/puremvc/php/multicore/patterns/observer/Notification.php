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

require_once 'org/puremvc/php/multicore/interfaces/INotification.php';

/**
 * A base <b>INotification</b> implementation.
 *
 * PureMVC does not rely upon underlying event models such
 * as the one provided with others like Flash, and PHP does
 * not have an inherent event model.
 *
 * The Observer Pattern as implemented within PureMVC exists
 * to support event-driven communication between the
 * application and the actors of the MVC triad.
 *
 * PureMVC <b>Notification</b>s follow a 'Publish/Subscribe'
 * pattern. PureMVC classes need not be related to each other in a
 * parent/child relationship in order to communicate with one another
 * using <b>Notification</b>s.
 *
 * @see Observer
        org\puremvc\php\multicore\patterns\observer\Observer.php
 * @package org.puremvc.php.multicore
 *
 */
class Notification implements INotification
{

    /**
     * Name of the notification instance
     * @var string
     */
    private $name;

    /**
     * The type of the notification instance
     * @var string
     */
    private $type;

    /**
     * The body of the notification instance
     * @var mixed
     */
    private $body;

    /**
     * Constructor.
     *
     * @param string $name The name of the notification to send.
     * @param mixed $body The body of the notification (optional).
     * @param string $type The type of the notification (optional).
     */
    public function __construct( $name, $body=null, $type=null )
    {
        $this->name = $name;
        $this->body = $body;
        $this->type = $type;
    }

    /**
     * Name getter
     *
     * Get the name of the <b>Notification</b> instance.
     *
     * No setter, should be set by constructor only
     *
     * @return string Name of the <b>Notification</b> instance.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Body setter
     *
     * Set the body of the <b>Notification</b> instance.
     *
     * @param object $body The body of the <b>Notification</b> instance.
     * @return void
     */
    public function setBody( $body )
    {
        $this->body = $body;
    }

    /**
     * Body getter
     *
     * Get the body of the <b>Notification</b> instance.
     *
     * @return mixed The body of the <b>Notification</b> instance.
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Type setter
     *
     * Set the type of the <b>Notification</b> instance.
     *
     * @param string $type The type of the <b>Notification</b> instance.
     * @return void
     */
    public function setType( $type )
    {
        $this->type = $type;
    }

    /**
     * Type getter
     *
     * Get the type of the <b>Notification</b> instance.
     *
     * @return string The type of the <b>Notification</b> instance.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * String representation
     *
     * Get the string representation of the <b>INotification</b> instance
     *
     * @return string
     */
    public function toString()
    {
        $msg = "Notification Name: "+ $this->getName();
        $msg += "\nBody:".( is_null( $this->body ) ? "null" : $this->body );
        $msg += "\nType:".( is_null( $this->type ) ? "null" : $this->type );
        return $msg;
    }

}
