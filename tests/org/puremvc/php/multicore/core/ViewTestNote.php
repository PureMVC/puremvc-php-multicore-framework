<?php
/**
 * PureMVC PHP Multicore Unit Tests
 *
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 *
 * Created on Jully 24, 2009
 *
 * @version 1.0
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 * @copyright PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * @license http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported License
 * @package org.puremvc.php.multicore.unittest
 */
/**
 *
 */

require_once 'org/puremvc/php/multicore/interfaces/INotification.php';
require_once 'org/puremvc/php/multicore/patterns/observer/Notification.php';
/**
 * A Notification class used by ViewTest.
 *
 * @see ViewTest
        org\puremvc\php\core\view\ViewTest.php
 * @package org.puremvc.php.multicore.unittest
 */
class ViewTestNote extends Notification implements INotification
{
    /**
     * The name of this Notification.
     */
    const NAME = 'ViewTestNote';
    /**
     * Constructor
     *
     *@param name Ignored and forced to NAME.
     *@param body the <b>Notification</b> body. (optional)
     *@param type the type of the <b>Notification</b> (optional)
     */
    public function __construct( $name, $body = null )
    {
        parent::__construct( ViewTestNote::NAME, $body );
    }

    /**
     * Factory method.
     *
     * <P>
     * This method creates new instances of the ViewTestNote class,
     * automatically setting the note name so you don't have to. Use
     * this as an alternative to the constructor.</P>
     *
     * @param name the name of the Notification to be constructed.
     * @param body the body of the Notification to be constructed.
     */
    public static function create( $body )
    {
        return new ViewTestNote( ViewTestNote::NAME, $body );
    }
}

?>
